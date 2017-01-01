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

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';

class SquadManagementViewEditAppointment extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$id = JRequest::getVar( 'id', '', 'default', 'int' );
		
		$form = $this->get('Form');
		$this->form = $form;
		$canAddAppointment = SquadmanagementHelper::canAddAppointments();
		
		$model = $this->getModel(); 
		$this->item = $model->getData($id);
		$this->assignRef('item',$this->item);
		$this->assignRef('id',$id);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$params = JComponentHelper::getParams( 'com_squadmanagement' ); 
		$this->assignRef('params',$params);		
		
		if ($id != -1)
		{
			$squad = SquadmanagementHelper::loadSquad($this->item->squadid);	
		}
		
		$user = JFactory::getUser();
		$userid = $user->get('id');
		if (($id == -1 && !$canAddAppointment) || ($id != -1 && ( $userid != $squad->squadleader && $userid != $squad->waradmin)))
		{			
			parent::display('noaccess');
			return false;
		}
		// Display the view
		parent::display($tpl);
	}
}
