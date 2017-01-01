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

// import Joomla view library
jimport('joomla.application.component.view');

class SquadManagementViewMyProfile extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$templateName = JRequest::getVar( 'squadmembertemplate', '', 'default', 'string' );
		$model = $this->getModel(); 
		$state = $this->get('State');	
		$params = &$state->params;		
		
		$this->assignRef('params',$params);	
		
		$user = JFactory::getUser();
		
		if ($user->guest) {
			parent::display('noaccess');
			return false;
		}	
		
		$userid = $user->get('id');
			
		$additionaltabs = $model->getProfileTabs();
		$additionalfields = $model->getProfileFields();
				
		$squadmember = $model->getData($userid);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}		
		
		
		$this->assignRef('templateName',$templateName);
		$this->assignRef('squadmember',$squadmember);
		$this->assignRef('additionaltabs', $additionaltabs);
		$this->assignRef('additionalfields', $additionalfields);
		
		// Display the view
		parent::display($tpl);
	}
}
