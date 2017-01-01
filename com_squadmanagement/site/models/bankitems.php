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

class SquadManagementModelBankItems extends JModelList
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}
	
	protected function getListQuery() 
	{
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('b');
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
						
		// Add the list ordering clause
		$orderCol = $this->state->get('list.ordering', 'b.itemdatetime');
		$orderDirn = $this->state->get('list.direction', 'desc');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));
		
		return $query;	
	}

	public function getItems()
	{
		if (!isset($this->cache['items'])) {
			$this->cache['items'] = parent::getItems();
		}
		return $this->cache['items'];
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
	
	public function getDuesByMembers()
	{		
		require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';
		
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('m');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();
		$membernameField = IntegrationHelper::getMembernameField();
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('m.id,'.$membernameField.', m.userid, m.fromdate, m.dues, m.payedto '.$avatarselect);

		$query->from('#__squad_member_additional_info m INNER JOIN #__users u ON m.userid = u.id INNER JOIN #__squad_member_additional_info i ON m.userid = i.userid '. $avatarjoin);
		$query->order('membername asc');
		
		$db->setQuery($query);
		
		return $db->loadObjectList();
	}
	
	protected function populateState($ordering = null, $direction = null) 
	{
		$app = JFactory::getApplication();
		
		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}
}
