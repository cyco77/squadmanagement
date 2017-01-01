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

// import Joomla view library
jimport('joomla.application.component.view');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';

class SquadManagementViewAppointment extends JViewLegacy
{
	protected $item;
	
	function display($tpl = null) 
	{
		$id = JRequest::getVar( 'id', '', 'default', 'int' );
		$model = $this->getModel();
		$item = $model->getData($id);
		$this->item = $item;
				
		if ($id == '')
		{
			$canAddAppointments = SquadmanagementHelper::canAddAppointments();
		}
		else
		{
			$canAddAppointments = SquadmanagementHelper::canEditAppointments($item->squadid);
		}
		$isUserInSquad = SquadManagementHelper::isInSquad($item->squadid);
		$isUserInAppointment = $this->isUserInAppointment();
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		
		$this->canAddAppointments = $canAddAppointments;
		$this->isUserInSquad = $isUserInSquad;
		$this->isUserInAppointment = $isUserInAppointment;
	
		$state = $this->get('State');	
		$params = &$state->params;
		$this->assignRef('params',$params);
		
		// Display the template
		parent::display($tpl);
	}	
	
	function isUserInAppointment()
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		if ($this->item != null 
			&& $this->item->members != null)
		{
			foreach ($this->item->members as $member)
			{
				if ($member->userid == $userid)
				{
					return true;
					break;
				}	
			}						
		}
		
		return false;
	}
}
