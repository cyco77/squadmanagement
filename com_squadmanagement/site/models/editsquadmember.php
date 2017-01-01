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

// import Joomla modelitem library
jimport('joomla.application.component.modeladmin');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';

class SquadManagementModelEditSquadMember extends JModelAdmin
{
	protected $_data;

	public function getTable($type = 'Squadmember', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.editsquadmember', 'editsquadmember', array('control' => 'jform', 'load_data' => $loadData));
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

			$id = JRequest::getVar( 'id', '', 'default', 'int' );

			$data = $this->getData($id);
			if ($data)
			{
				$this->getAdditionalInfos($data);
			}
		}
		return $data;
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
		
		$data->imageurl = $result->imageurl;	
		
		$fields = get_object_vars($result);
		
		foreach ($fields as $name=>$field)
		{
			if (SquadmanagementHelper::startsWith($name,'field_'))
			{
				$data->$name = $result->$name;
			}
		}
		
		return $result;
	}
	
	public function getAdditionalFields()
	{
		// Create a new query object.
		$db = JFactory::getDBO();

		// From the hello table
		$query = 'SELECT f.id, t.name as tabname, f.name, f.fieldtype, f.fieldname, f.maxlength, f.published, f.ordering ' .
			'FROM #__squad_member_additional_field AS f LEFT OUTER JOIN #__squad_member_additional_tab t ON f.tabid = t.id ' .
			'WHERE ( t.published = 1 or f.tabid = -1) and f.published = 1 ' .
			'order by t.ordering, f.ordering';
		$db->setQuery($query);
		
		return $db->loadObjectList();
	}

	public function &getData($id)
	{
		if (empty( $this->_data )) {
			
			require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		
			
			$avatarjoin = IntegrationHelper::getAvatarSqlJoin('i');
			$avatarselect = IntegrationHelper::getAvatarSqlSelect();
			
			$query = ' SELECT u.name, i.* '.$avatarselect.' FROM #__users u INNER JOIN #__squad_member_additional_info i ON u.id = i.userid '. $avatarjoin .
				'  WHERE i.userid = '.$id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		
		return $this->_data;
	}
	
	public function getProfileFields()
	{
		$query = 'SELECT * FROM #__squad_member_additional_field WHERE showinprofile = 1 AND published = 1 ORDER BY ordering';	
		$db = $this->getDbo();
		
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	public function getProfileTabs()
	{
		$query = 'SELECT * FROM #__squad_member_additional_tab WHERE published = 1 ORDER BY ordering';	
		$db = $this->getDbo();
		
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	public function updateItem($data)
	{
		$db = JFactory::getDbo();		
		$query = $db->getQuery(true);
		
		$query->update('#__squad_member_additional_info i');
		$query->set('i.imageurl = '.$db->quote($data['imageurl']));
		$query->set('i.displayname = '.$db->quote($data['displayname']));
		$query->set('i.steamid = '.$db->quote($data['steamid']));
		$query->set('i.description = '.$db->quote($data['description']));
		
		foreach ($data as $name=>$field)
		{
			if (SquadmanagementHelper::startsWith($name,'field_'))
			{
				$query->set('i.'.$name.' = '.$db->quote($field));
			}
		}
		
		$query->where('i.userid = ' . (int)$data['userid']);
		$db->setQuery($query);
		
		$db->query();
		
		if ($db->getErrorMsg()) {
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} else {
			return true;
		}
	}
}

?>