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
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'imagehelper.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		

class SquadManagementModelEditWar extends JModelForm
{
	public function getTable($type = 'War', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.editwar', 'editwar', array('control' => 'jform', 'load_data' => $loadData));
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
			$id = JRequest::getVar( 'id', '', 'default', 'int' );

			$data = $this->getData($id);
		}
		return $data;
	}
	
	public function getData($id)
	{						
		if (empty( $this->_data )) {
			$query = ' SELECT w.id, w.wardatetime, w.state, w.squadid, s.name as squad, s.image as squadlogo, w.opponentid, o.name as opponent,' .
				' o.logo as opponentlogo, w.leagueid, l.name as league, l.logo as leaguelogo, w.matchlink, w.lineup, w.lineupopponent, w.score, w.scoreopponent,' .
				' w.resultscreenshot, w.challengedescription, w.description, w.createdby, w.published, s.squadleader, s.waradmin'.
				' FROM #__squad_war w INNER JOIN #__squad s ON w.squadid = s.id INNER JOIN #__squad_opponent o ON w.opponentid = o.id INNER JOIN #__squad_league l ON w.leagueid = l.id' .
				' WHERE w.id = '.$id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		
		return $this->_data;
	}
	
	public function getMembers($warid)
	{	
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('m');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();
		
		$membernameField = IntegrationHelper::getMembernameField();
		
		$db = JFactory::getDBO();
		
		$query = 'SELECT wm.id, '.$membernameField.', u.id as userid, wm.state, wm.comment, wm.position'.$avatarselect.'
			FROM #__squad_war w
			INNER JOIN #__squad_member m ON w.squadid = m.squadid
			LEFT OUTER JOIN #__squad_member_additional_info i ON m.userid = i.userid
			INNER JOIN #__users u ON m.userid = u.id
			LEFT OUTER JOIN #__squad_war_member wm ON w.id = wm.warid AND u.id = wm.memberid '.$avatarjoin. ' 
			WHERE w.id = '.$warid.' and m.memberstate in (1,2) and m.published = 1';
		
		$db->setQuery($query);
		
		$result1 = $db->loadObjectList();
		
		$query = 'SELECT wm.id, u.username as membername, \'\' as avatar, u.id as userid, wm.state, wm.comment, wm.position 
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
	
	public function getCanAddWars()
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		if ($userid == 0)
		{
			return false;
		}
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');

		$query->from('#__squad s');
		
		$query->where('s.published = 1 AND (s.squadleader = '.$userid.' OR s.waradmin = '.$userid.')');
		
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		return count($result) > 0;
	}
	
	public function addItem($data)
	{
		$db = JFactory::getDbo();		
		$query = $db->getQuery(true);
		
		if ($data['opponentid'] == -1 && $data['opponentname'] != '')
		{
			$query = 'SELECT id FROM #__squad_opponent WHERE name = ' . $db->quote($data['opponentname']) . ' ORDER BY ID DESC limit 1';	
			$db = $this->getDbo();
			
			$db->setQuery($query);
			$value = $db->loadObject();
			
			$data['opponentid'] = $value->id;
		}		
		
		$query = $db->getQuery(true);
		$query->insert('#__squad_war');
		$query->set('wardatetime = '.$db->quote($data['wardatetime']));
		$query->set('state = '.$db->quote($data['state']));
		$query->set('squadid = '.$db->quote($data['squadid']));
		$query->set('opponentid = '.$db->quote($data['opponentid']));
		$query->set('leagueid = '.$db->quote($data['leagueid']));
		$query->set('matchlink = '.$db->quote($data['matchlink']));
		$query->set('lineup = '.$db->quote($data['lineup']));
		$query->set('lineupopponent = '.$db->quote($data['lineupopponent']));
		$query->set('score = '.$db->quote($data['score']));
		$query->set('scoreopponent = '.$db->quote($data['scoreopponent']));
		$query->set('resultscreenshot = '.$db->quote($data['resultscreenshot']));
		$query->set('challengedescription = '.$db->quote($data['challengedescription']));
		$query->set('description = '.$db->quote($data['description']));
		
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
		
		$query->set('result = '.$db->quote($data['result']));	
		
		$db->setQuery($query);
		
		$result = $db->query();
		$newId = $db->insertid();
		
		$this->extractAndSaveWarMembers($newId);
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return -1;
		} 
		else 
		{
			return $newId;
		}
	}
	
	public function updateItem($data)
	{
		$db = JFactory::getDbo();		
		$query = $db->getQuery(true);
		
		if ($data['opponentid'] == -1 && $data['opponentname'] != '')
		{
			$query = 'SELECT id FROM #__squad_opponent WHERE name = ' . $db->quote($data['opponentname']) . ' ORDER BY ID DESC limit 1';	
			$db = $this->getDbo();
		
			$db->setQuery($query);
			$value = $db->loadObject();
			
			$data['opponentid'] = $value->id;
		}		
		
		$query = $db->getQuery(true);
		$query->update('#__squad_war w');
		$query->set('w.wardatetime = '.$db->quote($data['wardatetime']));
		$query->set('w.state = '.$db->quote($data['state']));
		$query->set('w.squadid = '.$db->quote($data['squadid']));
		$query->set('w.opponentid = '.$db->quote($data['opponentid']));
		$query->set('w.leagueid = '.$db->quote($data['leagueid']));
		$query->set('w.matchlink = '.$db->quote($data['matchlink']));
		$query->set('w.lineup = '.$db->quote($data['lineup']));
		$query->set('w.lineupopponent = '.$db->quote($data['lineupopponent']));
		$query->set('w.score = '.$db->quote($data['score']));
		$query->set('w.scoreopponent = '.$db->quote($data['scoreopponent']));
		$query->set('w.resultscreenshot = '.$db->quote($data['resultscreenshot']));
		$query->set('w.challengedescription = '.$db->quote($data['challengedescription']));
		$query->set('w.description = '.$db->quote($data['description']));
		
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
		
		$query->set('result = '.$db->quote($data['result']));
		
		$query->where('w.id = ' . (int)$data['id']);
		$db->setQuery($query);
		
		$result = $db->query();
				
		$this->extractAndSaveWarMembers((int)$data['id']);
				
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

?>