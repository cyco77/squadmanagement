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

class SquadManagementModelWarrounds extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'warid', 'a.warid',
				'map', 'a.map',
				'mapimage', 'a.mapimage',
				'score', 'wscore',
				'score_opponent', 'a.score_opponent',
				'screenshot', 'a.screenshot'
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
					'a.id, a.warid, a.map, a.mapimage, a.score, a.score_opponent, a.screenshot'
					)
				);
		
		$query->from('#__squad_war_round a');
		$query->order('id');					
		return $query;	
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		$context = $this->context;

		$search = $this->getUserStateFromRequest($context . '.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_squadmanagement');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.id', 'asc');
	}
	
	public function getTable($type = 'Warround', $prefix = 'WarroundTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getRounds($warid)
	{
		$db = JFactory::getDBO();
		
		$query = 'SELECT w.id, w.warid, w.map, w.mapimage, w.score, w.score_opponent, w.screenshot';
		$query .= ' FROM #__squad_war_round w';
		$query .= ' WHERE w.warid = '.$warid;
		$query .= ' ORDER BY id';
		
		$db->setQuery($query);
		
		return $db->loadObjectList();
	}
}
