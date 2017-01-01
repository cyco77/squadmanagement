<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squad Management!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2014 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.larshildebrandt.de
# Technical Support:  Forum - http://www..larshildebrandt.de/forum/
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import joomla controller library
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('SquadManagement');

$task	= JRequest::getCmd('task');

switch ($task)
{
	case 'addmember':
		$controller->addmember(JRequest::getVar('userid'),JRequest::getVar('squadid'),JRequest::getVar('role'));
		break;
	case 'removemember':
		$controller->removemember(JRequest::getVar('id'),JRequest::getVar('squadid'));
		break;		
	case 'removewarround':
		$controller->removewarround(JRequest::getVar('id'));
		break;	
	case 'savewarround':
		$controller->savewarround(JRequest::getVar('warid'),JRequest::getVar('map'),JRequest::getVar('mapimage'),JRequest::getVar('screenshot'),JRequest::getVar('score'),JRequest::getVar('scoreopponent'));
		break;	
	case 'saveopponent':
		$controller->saveopponent(JRequest::getVar('name'),JRequest::getVar('logo'),JRequest::getVar('contact'),JRequest::getVar('contactemail'),JRequest::getVar('url'));
		break;		
	case 'deleteappointment':
		$controller->deleteappointment(JRequest::getVar('id'));
		break;		
	case 'addtoappointment':
		$controller->addtoappointment(JRequest::getVar('id'));
		break;	
	case 'removefromappointment':
		$controller->removefromappointment(JRequest::getVar('id'));
		break;						
	default:
	{
		// Perform the Request task
		$controller->execute( JRequest::getVar('task'));	
		break;
	}
}

$controller->redirect();