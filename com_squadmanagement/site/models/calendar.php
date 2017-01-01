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

class SquadManagementModelCalendar extends JModelLegacy
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'w.id',
				'wardatetime', 'w.wardatetime', 
				'squadid', 'w.squadid',
				'squad', 's.name',
				'squadlogo', 's.icon',
				'opponent', 'o.name',
				'opponentlogo', 'o.logo',
				'league', 'l.name',
				'matchlink', 'w.matchlink',
				'lineup', 'w.lineup',
				'lineupopponent', 'w.lineupopponent',
				'score', 'w.score',
				'scoreopponent', 'w.scoreopponent',
				'resultscreenshot', 'w.resultscreenshot',
				'description', 'w.description',
				'state', 's.state',
				'createdby', 'w.createdby',
				'published', 'w.published'
				);
		}

		parent::__construct($config);
	}
	
	function getSquadappointments($year,$month)
	{
		$query = 'SELECT a.id, a.type, a.startdatetime, a.enddatetime, a.duration, a.subject, a.published, a.ordering, s.name as squadname, s.icon as squadimage';
		
		$query .= ' FROM #__squad_appointment a';
		$query .= ' INNER JOIN #__squad s ON s.id = a.squadid';
		$query .= ' WHERE a.published = 1 and year(a.startdatetime) = '.$year.' and month(a.startdatetime) = '.$month;
		$query .= ' ORDER BY a.startdatetime';
		
		$db = $this->getDbo();
		
		$db->setQuery($query); 
		return $db->loadObjectList();
	}
	
	public function getCalendarItems($year,$month)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'w.id, w.wardatetime, w.state, w.squadid, s.name as squad, s.icon as squadlogo, o.name as opponent, o.logo as opponentlogo, l.name as league, w.matchlink, w.lineup, w.lineupopponent, w.score, w.scoreopponent, w.result, w.resultscreenshot, w.description, w.createdby, w.published'
					)
				);

		$query->from('#__squad_war w INNER JOIN #__squad s ON w.squadid = s.id INNER JOIN #__squad_opponent o ON w.opponentid = o.id INNER JOIN #__squad_league l ON w.leagueid = l.id');
		
		$query->where('w.published = 1 and w.state in (0,1) and year(w.wardatetime) = '.$year.' and month(w.wardatetime) = '.$month);
		
		$query->order('wardatetime desc');
		$db->setQuery($query,0,0);
		return $db->loadObjectList();
	}	
		
	protected function populateState($ordering = null, $direction = null) 
	{
		$app = JFactory::getApplication();
		// Get the message id
		$input = JFactory::getApplication()->input;
		$id = $input->getInt('filter_squad_id');
		$this->setState('filter.squadid', $id);
		
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}
}
