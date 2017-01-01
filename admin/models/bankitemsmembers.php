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

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

class SquadManagementModelBankItemsMembers extends JModelLegacy
{
	public function getMembers()
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
}

?>