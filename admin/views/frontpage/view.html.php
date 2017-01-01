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

class SquadManagementViewFrontpage extends JViewLegacy
{
	function display($tpl = null) 
	{
		// Set the toolbar
		$this->addToolBar();

		$model = $this->getModel();
		$this->challengecount = $model->getChallengeCount();
		$this->trialcount = $model->getTrialCount();

		// Display the template
		parent::display($tpl);
	}

	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_SQUADMANAGEMENT_MANAGER_SQUADMANAGEMENT'),'squadmanagement');		
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_squadmanagement',520,650);
	}
}
