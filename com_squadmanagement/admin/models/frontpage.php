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

class SquadManagementModelFrontpage extends JModelLegacy
{

	public function getChallengeCount()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('count(*) as ChallengeCount');

		$query->from('#__squad_war');

		$query->where('state = 2');
		$db->setQuery($query);
		$result =  $db->loadObject();	
		return $result->ChallengeCount;
	}
	
	public function getTrialCount()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('count(*) as TrialCount');

		$query->from('#__squad_member');

		$query->where('memberstate = 0');
		$db->setQuery($query);
		$result =  $db->loadObject();	
		return $result->TrialCount;
	}

}

?>