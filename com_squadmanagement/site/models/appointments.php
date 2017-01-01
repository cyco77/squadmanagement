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

class SquadManagementModelAppointments extends JModelList
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	protected function getListQuery() 
	{
		$id = JRequest::getVar( 'id', '', 'default', 'int' );
		
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select(
			$this->getState(
					'list.select',
					'a.id, a.type, a.startdatetime, a.enddatetime, a.duration, a.subject, a.published, a.ordering, s.name as squadname, s.icon as squadlogo'
					)
				);
		
		$query->from('#__squad_appointment a INNER JOIN #__squad s ON s.id = a.squadid');
		$query->where('a.published = 1 and a.startdatetime > UTC_TIMESTAMP()');	
		
		if ($id != '')
		{
			$query->where('a.squadid = '.(int)$id);
			
		}
			
		$query->order('a.startdatetime');
		return $query;
	}

	public function getItems()
	{
		if (!isset($this->cache['items'])) {
			$this->cache['items'] = parent::getItems();
		}
		return $this->cache['items'];
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
