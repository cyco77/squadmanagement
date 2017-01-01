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
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';

class SquadManagementModelEditSquad extends JModelForm
{
	public function getTable($type = 'Squad', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.editsquad', 'editsquad', array('control' => 'jform', 'load_data' => $loadData));
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
			$id = JRequest::getVar( 'id', '', 'default', 'int' );

			$data = $this->getData($id);
		}
		return $data;
	}
	
	public function getData($id)
	{		
		$query = ' SELECT * from #__squad WHERE id = '.$id;
		$this->_db->setQuery( $query );
		$data = $this->_db->loadObject();
		
		if ($data == null)
		{
			return null;	
		}
		// load members
		$data->members = $this->getMemberList($id);
		
		return $data;
	}
	
	function getMemberList( $squadid )
	{		
		require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';
		
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('sm');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();		
		
		$db = JFactory::getDBO();
		$id =   @$options['id'];
		$select = 'sm.*, u.name, i.displayname, i.imageurl '.$avatarselect;
		$from = '#__squad_member sm INNER JOIN #__users u ON sm.userid = u.id LEFT OUTER JOIN #__squad_member_additional_info i ON sm.userid = i.userid'.$avatarjoin;
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE sm.published = 1 AND squadid = ".$squadid. 
			"\n   ORDER BY ordering";
		
		$result = $this->_getList( $query );
		return @$result;
	}
	
	function getUserList($userpart)
	{
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__users WHERE name like '%".$userpart."%'";  
		$db->setQuery($query);      

		return $db->loadObjectList();	
	}
	
	public function updateItem($data)
	{
		$db = JFactory::getDbo();		
		$query = $db->getQuery(true);
		
		$query->update('#__squad s');
		$query->set('s.shortname = '.$db->quote($data['shortname']));
		$query->set('s.name = '.$db->quote($data['name']));
		$query->set('s.waradmin = '.$db->quote($data['waradmin']));
		$query->set('s.icon = '.$db->quote($data['icon']));
		$query->set('s.image = '.$db->quote($data['image']));
		$query->set('s.description = '.$db->quote($data['description']));
			
		$query->where('s.id = ' . (int)$data['id']);
		$db->setQuery($query);
		
		$db->query();
		
		// update Members		
		foreach($data as $key => $value)
		{
			if (SquadmanagementHelper::startsWith($key, 'squadmember_memberstate_'))
			{
				$id = str_replace('squadmember_memberstate_','',$key);
				
				$query = 'UPDATE #__squad_member SET memberstate = \'' . $value . '\' WHERE id = '.$id;
				$db->setQuery($query);				
				$db->query();
			}
			
			if (SquadmanagementHelper::startsWith($key, 'squadmember_role_'))
			{
				$id = str_replace('squadmember_role_','',$key);
				
				$query = 'UPDATE #__squad_member SET role = \'' . $value . '\' WHERE id = '.$id;
				$db->setQuery($query);				
				$db->query();
			}
			
			if (SquadmanagementHelper::startsWith($key, 'squadmember_ordering_'))
			{
				$id = str_replace('squadmember_ordering_','',$key);
				
				$query = 'UPDATE #__squad_member SET ordering = \'' . $value . '\' WHERE id = '.$id;
				$db->setQuery($query);				
				$db->query();
			}
		}		
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} 
		else 
		{
			return true;
		}
	}
}

?>