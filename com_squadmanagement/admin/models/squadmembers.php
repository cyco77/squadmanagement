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

class SquadManagementModelSquadmembers extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'm.id',
				's.name',
				'memberstate', 'm.memberstate',
				'icon', 's.icon',
				'name', 'u.name',
				'displayname', 'i.displayname',
				'role', 'm.role',
				'published', 'm.published',
				'ordering', 'm.ordering'
				);
		}

		parent::__construct($config);
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
		parent::populateState('m.ordering', 'asc');
	}
	
	protected function getListQuery() 
	{
		require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';
				
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('m');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();
		
		// Create a new query object.
		$db = $this->getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'm.id, s.name as squad, s.icon, u.name, m.role, i.displayname, i.imageurl, m.memberstate, m.published, m.ordering '.$avatarselect
					)
				);
		$query->from('#__squad_member m LEFT OUTER JOIN #__squad s on m.squadid = s.id INNER JOIN #__users u ON m.userid = u.id LEFT OUTER JOIN #__squad_member_additional_info i ON m.userid = i.userid '. $avatarjoin);
		
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('m.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(m.published IN (0, 1))');
		}
		
		// Filter by search in name
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('w.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(s.name LIKE '.$search.' OR u.name LIKE '.$search.')');
			}
		}

		// Filter on the state.
		//$state = $this->getState('filter.state');
		//if ($state != -1) {
		//	$query->where('m.memberstate = ' . $db->quote($state));
		//}
		
		// Add the list ordering clause
		$orderCol = $this->state->get('list.ordering', 'm.name');
		$orderDirn = $this->state->get('list.direction', 'asc');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));
		
		return $query;		
	}
}
