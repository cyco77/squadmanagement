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

class SquadManagementViewLeague extends JViewLegacy
{
	var $canDo;
	
	function display($tpl = null) 
	{
		$this->canDo = SquadmanagementHelper::getActions();
		if (!$this->canDo->get('com_squadmanagement.league')) 
		{
			return JError::raiseWarning( 500, JText::_( 'COM_SQUADMANAGEMENT_NOACCESS' ) );
		}		
		
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');		

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);
	}

	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_SQUADMANAGEMENT_MANAGER_LEAGUE_NEW') : JText::_('COM_SQUADMANAGEMENT_MANAGER_LEAGUE_EDIT'),'league');
		JToolBarHelper::apply('league.apply');
		JToolBarHelper::save('league.save');
		JToolBarHelper::save2copy('league.save2copy');
		JToolBarHelper::save2new('league.save2new');
		JToolBarHelper::cancel('league.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}
