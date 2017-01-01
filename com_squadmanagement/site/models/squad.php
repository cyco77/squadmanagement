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

jimport('joomla.application.component.modelitem');

class SquadManagementModelSquad extends JModelItem
{
	protected $_data;

	public function getTable($type = 'Squad', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function &getData($id)
	{
		if (empty( $this->_data )) {
			
			$query = ' SELECT * from #__squad s '.
				'  WHERE s.id = '.$id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		
		$this->_data->members = $this->getMembers($id);
		$this->_data->wars = $this->getWars($id,10);
		$this->_data->awards = $this->getAwards($id,10);
		
		return $this->_data;
	}
	
	function getMembers($id)
	{
		require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		
		
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('m');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();
		
		$membernameField = IntegrationHelper::getMembernameField();
		
		$query = 'SELECT m.id, '.$membernameField.', m.role, u.lastvisitdate, s.guest, i.*, m.published, m.ordering'.$avatarselect;
				
		$query .= ' FROM #__squad_member m INNER JOIN #__users u ON m.userid = u.id LEFT OUTER JOIN #__squad_member_additional_info i ON m.userid = i.userid LEFT OUTER JOIN (SELECT distinct client_id ,guest, userid FROM #__session) s ON m.userid = s.userid and s.client_id = 0 '.$avatarjoin;
		$query .= ' WHERE m.published = 1 AND m.memberstate in (1,2) AND m.squadid = ' . $id;
		$query .= ' ORDER BY ordering';
		
		$db = $this->getDbo();
		
		$db->setQuery($query); 
		return $db->loadObjectList();
	}
	
	function getWars($id,$count)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'w.id, w.wardatetime, w.state, w.squadid, s.name as squad, s.icon as squadlogo, o.name as opponent, o.logo as opponentlogo, l.name as league, l.shortname as leagueshortname, w.matchlink, w.lineup, w.lineupopponent, w.score, w.scoreopponent, w.resultscreenshot, w.description, w.createdby, w.published'
					)
				);

		$query->from('#__squad_war w INNER JOIN #__squad s ON w.squadid = s.id INNER JOIN #__squad_opponent o ON w.opponentid = o.id INNER JOIN #__squad_league l ON w.leagueid = l.id');
		
		$query->where('w.state in (1) and w.squadid = '.$id);

		$query->order('wardatetime desc');
		$db->setQuery($query,0,$count); 
		return $db->loadObjectList();
	}
	
	function getAwards($id,$count)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'a.id, a.name, a.squadid, s.name as squadname, a.awarddate, a.place, a.url, a.imageurl, a.published, a.ordering'
					)
				);

		$query->from('#__squad_award a INNER JOIN #__squad s ON a.squadid = s.id');
		$query->where('a.published = 1');
		
		$query->where('a.squadid = '.(int)$id);

		$query->order('a.awarddate desc');
		$db->setQuery($query,0,$count); 
		return $db->loadObjectList();
	}
	
	public function getListFields()
	{
		$query = 'SELECT * FROM #__squad_member_additional_field WHERE showinlist = 1 AND published = 1 ORDER BY ordering';	
		$db = $this->getDbo();
		
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		
		$params = $app->getParams();
		$this->setState('params', $params);
	}
}

?>