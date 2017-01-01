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

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		

class SquadManagementModelBankItems extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'b.id',
				'itemdatetime', 'b.itemdatetime',
				'subject', 'b.subject',
				'amount', 'b.amount',
				'type', 'b.type',
				'userid', 'b.userid',
				'published', 'b.published',
				'ordering', 'b.ordering',			
				);
		}
		
		parent::__construct($config);
	}
	
	protected function getListQuery() 
	{
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('a');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();
		
		$membernameField = IntegrationHelper::getMembernameField();
		
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'b.id, b.subject, b.itemdatetime, b.type, b.userid, b.amount, '.$membernameField.', b.published, b.ordering '.$avatarselect
					)
				);
		
		$query->from('#__squad_bankitem b LEFT OUTER JOIN #__users u ON b.userid = u.id LEFT OUTER JOIN #__squad_member_additional_info i ON b.userid = i.userid '.$avatarjoin);
		
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('b.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(b.published IN (0, 1))');
		}
		
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('b.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(b.subject LIKE ' . $search . ')');
			}
		}
		
		// Add the list ordering clause
		$orderCol = $this->state->get('list.ordering', 'b.itemdatetime');
		$orderDirn = $this->state->get('list.direction', 'desc');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));
		
		return $query;	
	}
	
	function getSum()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('Sum(amount*type) as sum ');		
		$query->from('#__squad_bankitem a');	
		$query->where('a.published = 1');
		
		$db->setQuery($query);
		return $db->loadObject();
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
		parent::populateState('b.itemdatetime', 'desc');
	}
	
	public function getTable($type = 'BankItemField', $prefix = 'BankItemTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
}
