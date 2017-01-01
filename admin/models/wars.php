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

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class SquadManagementModelWars extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'wardatetime', 'a.wardatetime',
				'state','a.state',
				'squad', 's.squad',
				'squadlogo', 's.squadlogo',
				'opponent', 'o.opponent',
				'opponentlogo', 'o.opponentlogo',
				'league', 'l.league',
				'matchlink', 'a.matchlink',
				'lineup', 'a.lineup',
				'lineupopponent', 'a.lineupopponent',
				'score', 'wscore',
				'scoreopponent', 'a.scoreopponent',
				'resultscreenshot', 'a.resultscreenshot',
				'description', 'a.description',
				'createdby', 'a.createdby',
				'published', 'a.published'
				);
		}

		parent::__construct($config);
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$stateId = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '-1');
		$this->setState('filter.state', $stateId);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_squadmanagement');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.wardatetime', 'desc');
	}
	
	protected function getListQuery() 
	{
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'a.id, a.wardatetime, a.state, s.name as squad, s.icon as squadlogo, o.name as opponent, o.logo as opponentlogo, l.name as league, a.matchlink, a.lineup, a.lineupopponent, a.score, a.scoreopponent, a.resultscreenshot, a.description, a.createdby, a.published'
					)
				);

		$query->from('#__squad_war a LEFT OUTER JOIN #__squad s ON a.squadid = s.id LEFT OUTER JOIN #__squad_opponent o ON a.opponentid = o.id LEFT OUTER JOIN #__squad_league l ON a.leagueid = l.id');
		
		// Filter by search in name
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('w.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(o.name LIKE '.$search.' OR s.name LIKE '.$search.')');
			}
		}

		// Filter on the state.
		$state = $this->getState('filter.state');
		if ($state != -1) {
			$query->where('a.state = ' . $db->quote($state));
		}
		
		// Add the list ordering clause
		$orderCol = $this->state->get('list.ordering', 'a.name');
		$orderDirn = $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));
		
		return $query;
	}

}

?>