<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squadmanagement!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2014 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.larshildebrandt.de
# Technical Support:  Forum - http://www..larshildebrandt.de/forum/
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

class SquadManagementModelAdditionalField extends JModelAdmin
{
	public function getTable($type = 'AdditionalField', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.additionalfield', 'additionalfield', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_squadmanagement.edit.additionalfield.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
			$data->org_fieldname = $data->fieldname;
			$data->org_maxlength = $data->maxlength;
			$data->org_fieldtype = $data->fieldtype;
		}
		return $data;
	}
	
	public function save($data)
	{		
		if ($data['id'] == 0)
		{
			$fieldname = strtolower($data['fieldname']);
			$fieldname = ereg_replace("[^a-z_]", "", $fieldname );
			
			$needle = 'field_';
			$length = strlen($needle);
							
			if (substr($fieldname, 0, $length) != $needle)
			{				
				$data['fieldname'] = 'field_'.$fieldname;
			}
			
			$this->addDbColumn($data);
		}
		else
		{
			if ($data['fieldname'] != $data['org_fieldname']
				|| $data['fieldtype'] != $data['org_fieldtype']
				|| $data['maxlength'] != $data['org_maxlength'])
			{
				$this->updateDbColumn($data);
			}	
		}
		
		$result = parent::save($data);
		
		if ($data->ordering < 1)
		{
			$table = $this->getTable();
			$table->reorder();	
		}
		
		return $result;
	}
	
	function addDbColumn($data)
	{
		$db = $this->getDbo();
		
		switch ($data['fieldtype'])
		{
			case 'date':
				$mysqltype = ' DATE ';
				$data['maxlength'] = ' - ';
				break;
			case 'number':
				$mysqltype = ' INT ';
				$data['maxlength'] = ' - ';
				break;					
			default:
				$mysqltype = ' VARCHAR('.$data[maxlength].') ';
		}	
		
		$query = "ALTER TABLE #__squad_member_additional_info ADD COLUMN ".$data[fieldname].$mysqltype;
		
		$db->setQuery($query);
		$db->query();
	}
	
	function updateDbColumn($data)
	{
		$db = $this->getDbo();
		
		switch ($data['fieldtype'])
		{
			case 'date':
				$mysqltype = ' DATE ';
				$data['maxlength'] = ' - ';
				break;
			case 'number':
				$mysqltype = ' INT ';
				$data['maxlength'] = ' - ';
				break;					
			default:
				$mysqltype = ' VARCHAR('.$data[maxlength].') ';
		}	
		
		$query = "ALTER TABLE #__squad_member_additional_info CHANGE COLUMN ".$data[org_fieldname]." ".$data[fieldname].$mysqltype;
		
		$db->setQuery($query);
		$db->query();
	}
	
	public function delete(&$pks)
	{
		$table = $this->getTable();

		// Iterate the items to delete each one.
		foreach ($pks as $i => $pk)
		{
			if ($table->load($pk))
			{
				$this->deleteDbColumn($table);
			}
		}
		
		parent::delete($pks);		
	}
	
	function deleteDbColumn($table)
	{
		$db = $this->getDbo();
		
		$query = "ALTER TABLE #__squad_member_additional_info DROP COLUMN ".$table->fieldname." ;";
		
		$db->setQuery($query);
		$db->query();
	}
}
