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

class SquadManagementModelWar extends JModelAdmin
{
	public function getTable($type = 'War', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.war', 'war', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_squadmanagement.edit.war.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	public function getMembers($warid)
	{
		if (!isset($warid))
		{
			return null;
		}
	
		$db = JFactory::getDBO();
		
		$query = 'SELECT wm.id, u.username, u.id as userid, wm.state, wm.comment, wm.position
			FROM #__squad_war w
			INNER JOIN #__squad_member m ON w.squadid = m.squadid
			INNER JOIN #__users u ON m.userid = u.id
			LEFT OUTER JOIN #__squad_war_member wm ON w.id = wm.warid AND u.id = wm.memberid
			WHERE w.id = '.$warid.' and m.memberstate in (1,2) and m.published = 1';
		
		$db->setQuery($query);
		
		$result1 = $db->loadObjectList();
				
		$query = 'SELECT wm.id, u.username, u.id as userid, wm.state, wm.comment, wm.position 
			FROM #__users u
			INNER JOIN #__squad_war_member wm ON u.id = wm.memberid
			WHERE wm.warid = '.$warid;
		
		$db->setQuery($query);
		
		$result2 = $db->loadObjectList();
			
		$result = array();
		
		foreach ($result1 as $item)
		{
			$result[$item->userid] = $item;
		}			
		
		foreach ($result2 as $item)
		{
			if (!array_key_exists($item->userid, $result))
			{
				$result[$item->userid] = $item;	
			}
		}
		
		return $result;
	}
	
	public function save($data)
	{		
		$_POST["jform_field_cpu"];
		
		$this->extractAndSaveWarMembers($data['id']);
		
		if ($data['state'] == 1)
		{				
			if ($data['score'] == $data['scoreopponent'])
			{
				$data['result'] = '0';
			}				
			if ($data['score'] > $data['scoreopponent'])
			{
				$data['result'] = '1';
			}
			if ($data['score'] < $data['scoreopponent'])
			{
				$data['result'] = '-1';
			}
		}
		else
		{
			$data['result'] = '';
		}
		
		$result = parent::save($data);
		
		if ($data->ordering < 1)
		{
			$table = $this->getTable();
			$table->reorder();	
		}
		
		return $result;
	}
	
	public function extractAndSaveWarMembers($warid)
	{		
		foreach ($_POST['jform'] as $key => $element)
		{						
			if (strpos($key, 'warmemberid_id_') === 0)	
			{
				$warMember =new stdClass();
				$warMember->id = $element;
				$warMember->userid = substr($key,15);
			}
			
			if (strpos($key, 'warmemberstate_id_') === 0)	
			{
				$warMember->state = $element;
			}
			
			if (strpos($key, 'warmemberposition_id_') === 0)	
			{
				$warMember->position = $element;
				$this->saveWarMember($warMember,$warid);
			}
		}	
	}
	
	public function saveWarMember($member,$warid)
	{
		$db = JFactory::getDbo();		
		$query = $db->getQuery(true);
		
		if ($member->id != '')
		{
			$query->update('#__squad_war_member');	
			$query->where('id = ' . $member->id);
		}
		else
		{
			$query->insert('#__squad_war_member');	
			$query->set('memberid = '.$db->quote($member->userid));
			$query->set('warid = '.$db->quote($warid));
		}		
						
		$query->set('position = '.$db->quote($member->position));
		$query->set('state = '.$db->quote($member->state));
		
		$db->setQuery($query);
		
		$result = $db->query();
		
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
