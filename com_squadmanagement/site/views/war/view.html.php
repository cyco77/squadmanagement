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

class SquadManagementViewWar extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$id = JRequest::getVar( 'id', '', 'default', 'int' );
		$templateName = JRequest::getVar( 'wartemplate', '', 'default', 'string' );
		
		$model = $this->getModel();
		$state = $this->get('State');	
		$item = $model->getData($id);
		$item->rounds = $model->getRounds($id);
		$item->members = $model->getMembers($id);
		$item->history = $model->getHistory($item->squadid);
		$isUserInSquad = $model->isUserInSquad($item->squadid);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->assignRef('templateName',$templateName);
		$this->assignRef('item',$item);		
		$this->assignRef('isUserInSquad',$isUserInSquad);
		
		$params = &$state->params;
		$this->assignRef('params',$params);
		
		// Display the view
		parent::display($tpl);
	}
}
