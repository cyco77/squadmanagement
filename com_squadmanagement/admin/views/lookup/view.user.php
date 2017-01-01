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

jimport( 'joomla.application.component.view' );

class   SquadManagementViewLookup extends JViewLegacy
{
	function display($tpl = null)
	{
		
		$userpart = JRequest::getVar( 'userpart', '', 'default', 'string' );
			
		$db = JFactory::getDBO();

		$query = "SELECT * FROM #__users WHERE name like '%".$userpart."%'";  

		$db->setQuery($query);      

		$users = $db->loadObjectList();
		
		$this->assignRef('users', $users);		
		
		parent::display("user");
	}
	
}