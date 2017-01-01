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

jimport( 'joomla.html.html' );

class SquadManagementModelBankItem extends JModelAdmin
{
	public function getTable($type = 'BankItem', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.bankitem', 'bankitem', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_squadmanagement.edit.bankitem.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	public function save($data)
	{		
		$result = parent::save($data);
		
		$this->updatePayedUntil($data);
		
		if ($data->ordering < 1)
		{
			$table = $this->getTable();
			$table->reorder();	
		}
		
		return $result;
	}
	
	function updatePayedUntil($data)
	{
		$query = "update #__squad_member_additional_info set dues = '".$_POST['jform']['dues']."', payedto = '".$_POST['jform']['payedto']."' where userid = ".(int)$data['userid'];		
		
		$db = JFactory::getDBO();
		$db->setQuery($query);	
				
		$result = $db->query();
	}
	
	public function getUserData($userid)
	{		
		$query = 'SELECT i.userid, fromdate, i.dues, i.payedto FROM #__squad_member_additional_info i where userid = '.(int)$userid;		
		
		$db = JFactory::getDBO();
		$db->setQuery($query);
		
		return $db->loadObject();
	}
}
