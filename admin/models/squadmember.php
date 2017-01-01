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

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';

class SquadManagementModelSquadmember extends JModelAdmin
{
	public function getTable($type = 'Squadmember', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.squadmember', 'squadmember', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_squadmanagement.edit.squadmember.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
			if ($data)
			{
				$this->getAdditionalInfos($data);
			}
		}
		return $data;
	}
	
	public function save($data)
	{	
		$additionalFields = $this->getAdditionalFields();
		$this->mergeAdditionalValues($data,$additionalFields);
		
		$this->saveAdditionalData($data,$additionalFields);
		
		$result = parent::save($data);
		
		return $result;
	}
	
	public function saveAdditionalData($data,$additionalFields)
	{
		$db = $this->getDbo();
		$query = "update #__squad_member_additional_info set imageurl = '".$data['imageurl']."', displayname = '".$data['displayname']."', description = '".addslashes($data['description'])."', dues = '".$_POST['jform']['dues']."', fromdate = '".$_POST['jform']['fromdate']."', steamid = '".$_POST['jform']['steamid']."', payedto = '".$_POST['jform']['payedto']."' ";
		
		foreach	($additionalFields as $field)
		{
			$query .= ", ".$field->fieldname." = '".$data[$field->fieldname]."' ";
		}		
		
		$query .= " where userid = ".$data['userid'];		
		
		$db->setquery($query);
		$db->query();
	}
	
	function mergeAdditionalValues(&$data,$additionalFields)
	{
		foreach	($additionalFields as $field)
		{
			$data[$field->fieldname] = str_replace("'","\'",$_POST['jform'][$field->fieldname]);
		}	
	}
	
	public function getAdditionalInfos($data)
	{
		$db = $this->getDbo();
		$id =   @$options['id'];
		$select = 'i.* ';
		$from = '#__squad_member_additional_info i ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE userid = " . $data->userid ;
		
		$db->setQuery($query);
		$result = $db->loadObject();
		
		if (isset($result))
		{
			$data->imageurl = $result->imageurl;	
			$data->displayname = $result->displayname;	
			$data->description = $result->description;
			$data->steamid = $result->steamid;
			
			$data->dues = $result->dues;
			$data->fromdate = $result->fromdate;
			if (!isset($data->fromdate) || $data->fromdate == '0000-00-00')
			{
				$data->fromdate = date("Y-m-d");	
			}
			
			$data->payedto = $result->payedto;
			if (!isset($data->payedto) || $data->payedto == '0000-00-00')
			{
				$data->payedto = date("Y-m-d");	
			}
			
			$fields = get_object_vars($result);
			
			foreach ($fields as $name=>$field)
			{
				if (SquadmanagementHelper::startsWith($name,'field_'))
				{
					$data->$name = $result->$name;
				}
			}
		}
		else
		{	
			$data->imageurl = '';	
			$data->displayname = '';	
			$data->description = '';
			$data->dues = '';
			$data->fromdate = date("Y-m-d");
			$data->payedto = '';
			$data->steamid = '';
		}
		
		return $result;
	}
	
	public function getAdditionalFields()
	{
		// Create a new query object.
		$db = JFactory::getDBO();

		$query = 'SELECT f.id, t.name as tabname, f.name, f.fieldtype, f.fieldname, f.maxlength, f.published, f.ordering ' .
			'FROM #__squad_member_additional_field AS f LEFT OUTER JOIN #__squad_member_additional_tab t ON f.tabid = t.id ' .
			'WHERE ( t.published = 1 or f.tabid = -1) and f.published = 1 ' .
			'order by t.ordering, f.ordering';
		$db->setQuery($query);
		
		return $db->loadObjectList();
	}
	
	public function hasMemberAdditionalInfoEntry($userid)
	{
		$db = $this->getDbo();
		$id =   @$options['id'];
		$select = '* ';
		$from = '#__squad_member_additional_info ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE userid = " . $userid;
		
		$result = $this->_getList( $query );
		
		return count($result) == 1;
	}
}

?>