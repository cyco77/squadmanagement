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

jimport('joomla.application.component.modellist');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		

class SquadManagementModelUserDashboard extends JModelList
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	protected function populateState($ordering = null, $direction = null) 
	{
		$app = JFactory::getApplication();
		
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}
	
	function getMemberInfo()
	{
		require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		
	
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('i');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();
		
		$membernameField = IntegrationHelper::getMembernameField();
		
		$query = 'SELECT '.$membernameField.', i.*'.$avatarselect;
		
		$query .= ' FROM #__squad_member_additional_info i INNER JOIN #__users u ON i.userid = u.id '.$avatarjoin;
		$query .= ' WHERE i.userid = ' . $userid;
		
		$db = $this->getDbo();
		
		$db->setQuery($query); 
		return $db->loadObject();
	}
	
	function getLastBankItem()
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id, itemdatetime, subject, type, amount');
		
		$query->from('#__squad_bankitem a');
		$query->where('published = 1 and userid ='.(int)$userid);
		
		$db->setQuery($query,1,1); 
		
		return $db->loadObject();
	}
	
	function getBankItems()
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id, itemdatetime, subject, type, amount');
		
		$query->from('#__squad_bankitem a');
		$query->where('published = 1 and userid ='.(int)$userid);			
		$query->order('itemdatetime desc');
		
		$db->setQuery($query); 
		
		return $db->loadObjectList();
	}
	
	function getAppointments()
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('a.id, a.type, a.startdatetime, a.enddatetime, a.duration, a.subject, a.published, a.ordering, s.name as squadname, s.image as squadlogo, am.state');
		
		$query->from('#__squad_appointment a 
			INNER JOIN #__squad_member m ON m.squadid = a.squadid
			INNER JOIN #__squad s ON s.id = a.squadid
			LEFT OUTER JOIN #__squad_appointment_member am ON a.id = am.appointmentid AND m.userid = am.userid');
		$query->where('a.published = 1 and a.startdatetime > UTC_TIMESTAMP() and m.userid ='.(int)$userid);			
		$query->order('a.startdatetime');
		
		$db->setQuery($query); 
		
		return $db->loadObjectList();
	}
	
	function getWars()
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('w.id, w.wardatetime, w.state as warstate, o.name as opponentname, o.logo as opponentlogo, s.name as squadname, s.icon as squadlogo, l.name as leaguename, l.logo as leaguelogo, wm.state');
		
		$query->from('#__squad_war w 
			INNER JOIN #__squad_opponent o ON w.opponentid = o.id
			INNER JOIN #__squad_league l ON w.leagueid = l.id
			INNER JOIN #__squad_member m ON m.squadid = w.squadid
			INNER JOIN #__squad s ON s.id = w.squadid
			LEFT OUTER JOIN #__squad_war_member wm ON w.id = wm.warid AND m.userid = wm.memberid');
		$query->where('w.published = 1 and w.wardatetime > UTC_TIMESTAMP() and m.userid ='.(int)$userid);			
		$query->order('w.wardatetime asc');
		
		$db->setQuery($query); 
		
		return $db->loadObjectList();
	}
	
	function getWarsHistory()
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('w.id, w.wardatetime, w.state as warstate, o.name as opponentname, o.logo as opponentlogo, s.name as squadname, s.icon as squadlogo, l.name as leaguename, l.logo as leaguelogo, wm.state');
		
		$query->from('#__squad_war w 
			INNER JOIN #__squad_opponent o ON w.opponentid = o.id
			INNER JOIN #__squad_league l ON w.leagueid = l.id
			INNER JOIN #__squad_member m ON m.squadid = w.squadid
			INNER JOIN #__squad s ON s.id = w.squadid
			LEFT OUTER JOIN #__squad_war_member wm ON w.id = wm.warid AND m.userid = wm.memberid');
		$query->where('w.published = 1 and w.wardatetime <= UTC_TIMESTAMP() and m.userid ='.(int)$userid);			
		$query->order('w.wardatetime desc');
		
		$db->setQuery($query); 
		
		return $db->loadObjectList();
	}
}
