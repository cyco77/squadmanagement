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

class SquadManagementModelSquad extends JModelAdmin
{
	public function getTable($type = 'Squad', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.squad', 'squad', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_squadmanagement.edit.squad.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	function getMemberList( $squadid )
	{		
		require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';
		
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('sm');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();		
		
		$db = JFactory::getDBO();
		$id =   @$options['id'];
		$select = 'sm.*, u.name, i.imageurl '.$avatarselect;
		$from = '#__squad_member sm INNER JOIN #__users u ON sm.userid = u.id LEFT OUTER JOIN #__squad_member_additional_info i ON sm.userid = i.userid'.$avatarjoin;
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE sm.published = 1 AND squadid = ".$squadid. 
			"\n   ORDER BY ordering";
		
		$result = $this->_getList( $query );
		return @$result;
	}
	
	function isUserInSquad($userid,$squadid)
	{
		$db = JFactory::getDBO();
		$id =   @$options['id'];
		$select = '* ';
		$from = '#__squad_member ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE userid = " . $userid . ' and squadid = ' . $squadid;
		
		$result = $this->_getList( $query );
		
		return count($result) == 1;
	}
	
	public function save($data)
	{	
		$result = parent::save($data);
		
		if ($data->ordering < 1)
		{
			$table = $this->getTable();
			$table->reorder();	
		}
		
		return $result;
	}
}
