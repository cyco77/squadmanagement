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

class SquadManagementViewEditSquad extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$id = JRequest::getVar( 'id', '', 'default', 'int' );
		
		$form = $this->get('Form');
		$this->form = $form;
		
		$model = $this->getModel(); 
		$this->item = $model->getData($id);
		$this->assignRef('item',$this->item);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$params = JComponentHelper::getParams( 'com_squadmanagement' ); 
		$this->assignRef('params',$params);		
		
		$user = JFactory::getUser();
		$userid = $user->get('id');
		if ($userid != $this->item->squadleader)
		{			
			parent::display('noaccess');
			return false;
		}
		// Display the view
		parent::display($tpl);
	}
}
