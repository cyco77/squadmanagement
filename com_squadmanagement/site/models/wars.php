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

class SquadManagementModelWars extends JModelList
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
	
	protected function getListQuery() 
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'w.id, w.wardatetime, w.state, w.squadid, s.name as squad, s.icon as squadlogo, o.name as opponent, o.logo as opponentlogo, l.name as league, w.matchlink, w.lineup, w.lineupopponent, w.score, w.scoreopponent, w.result, w.resultscreenshot, w.description, w.createdby, w.published'
					)
				);

		$query->from('#__squad_war w INNER JOIN #__squad s ON w.squadid = s.id INNER JOIN #__squad_opponent o ON w.opponentid = o.id INNER JOIN #__squad_league l ON w.leagueid = l.id');
	
		if ($this->getCanAddWars())
		{
			$query->where('w.published = 1 ');	
		}
		else
		{
			$query->where('w.published = 1 and w.state in (0,1)');	
		}		
	
		$squadid = $this->getState('filter.squadid');
		if (is_numeric($squadid) && $squadid > 0) {
			$query->where('w.squadid = '.(int) $squadid);
		}

		$query->order('wardatetime desc');
		return $query;
	}

	public function getItems()
	{
		if (!isset($this->cache['items'])) {
			$this->cache['items'] = parent::getItems();
		}
		return $this->cache['items'];
	}	
	
	public function getSummary()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('w.result, count(*) as number');

		$query->from('#__squad_war w');
		
		$query->where('w.published = 1 and w.state in (0,1) AND w.result is not null ');
		
		$squadid = $this->getState('filter.squadid');
		if (is_numeric($squadid) && $squadid > 0) {
			$query->where('w.squadid = '.(int) $squadid);
		}
		$query->group('w.result');
		$query->order('w.result');

		$db->setQuery($query,0,0);
		return $db->loadObjectList();
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
	
	protected function populateState($ordering = null, $direction = null) 
	{
		$app = JFactory::getApplication();
		// Get the message id
		$input = JFactory::getApplication()->input;
		$id = $input->getInt('filter_squad_id');
		$this->setState('filter.squadid', $id);
		
		$this->setState('list.start', 0);
		$this->setState('list.limit', 0);
		
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}
}
