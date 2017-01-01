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

jimport('joomla.application.component.model');

class SquadManagementModelSquads extends JModelList
{
	function _getSquadsQuery( &$options ){
		
		$ids = JRequest::getVar( 'id', '', 'default', 'array' );
		
		$db = JFactory::getDBO();
		$select = '*';
		$from = '#__squad ';
		$idsWhere = Count($ids) >= 1 && $ids[0] != '' ? 'AND id in (' . implode(",", array_map('intval', $ids)) . ')' : '';
		$wheres = 'published = 1 ' . $idsWhere;
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE " . $wheres .
			"\n   ORDER BY ordering, name";
		return $query;
	}

	function getSquadList( $options=array() ){
		$query = $this->_getSquadsQuery( $options );	
		$result = $this->_getList( $query );
		return @$result;
	}
	
	public function getMembers($id)
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