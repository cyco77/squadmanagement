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
jimport('joomla.application.component.modelitem');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'imagehelper.php');

class SquadManagementModelWar extends JModelItem
{
	protected $_data;

	public function getTable($type = 'War', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getData($id)
	{
		if (empty( $this->_data )) {
			$query = ' SELECT w.id, w.wardatetime, w.state, w.squadid, s.name as squad, s.image as squadlogo, o.name as opponent,' .
				' o.logo as opponentlogo, l.name as league, l.logo as leaguelogo, w.matchlink, w.lineup, w.lineupopponent, w.score, w.scoreopponent,' .
				' w.resultscreenshot, w.description, w.createdby, w.published, s.squadleader, s.waradmin'.
				' FROM #__squad_war w INNER JOIN #__squad s ON w.squadid = s.id INNER JOIN #__squad_opponent o ON w.opponentid = o.id INNER JOIN #__squad_league l ON w.leagueid = l.id' .
				' WHERE w.id = '.$id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		
		return $this->_data;
	}
	
	public function getHistory($squadid)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'w.id, w.wardatetime, w.squadid, s.name as squad, s.icon as squadlogo, o.name as opponent, o.logo as opponentlogo, l.name as league, w.matchlink, w.lineup, w.lineupopponent, w.score, w.scoreopponent, w.resultscreenshot, w.description, w.createdby, w.published'
					)
				);

		$query->from('#__squad_war w INNER JOIN #__squad s ON w.squadid = s.id INNER JOIN #__squad_opponent o ON w.opponentid = o.id INNER JOIN #__squad_league l ON w.leagueid = l.id');
		
		$query->where('w.state in (1)');
		
		$query->where('w.squadid = '.(int) $squadid);

		$query->order('wardatetime desc');
		$db->setQuery( $query, 0, 8 ); // TODO: Als Parameter auslagern 
		return $db->loadObjectList();
	}
	
	public function getRounds($id)
	{
		$query = 'SELECT * FROM #__squad_war_round WHERE warid = ' . $id;	
		$db = $this->getDbo();
		
		$db->setQuery($query);
		return $db->loadObjectList();
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
			WHERE w.id = '.$warid.' and wm.state = 1 and m.memberstate in (1,2) and m.published = 1';
		
		$db->setQuery($query);
		
		$result1 = $db->loadObjectList();
		
		$query = 'SELECT wm.id, u.username as membername, \'\' as avatar, u.id as userid, wm.state, wm.comment, wm.position 
			FROM #__users u
			INNER JOIN #__squad_war_member wm ON u.id = wm.memberid
			WHERE wm.state = 1 and wm.warid = '.$warid;
		
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
	
	function isUserInSquad($squadid)
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
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
	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		
		$params = $app->getParams();
		$this->setState('params', $params);
	}
}
