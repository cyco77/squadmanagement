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

class SquadManagementViewWars extends JViewLegacy
{
	function display($tpl = null) 
	{
		$warlisttemplateName = JRequest::getVar( 'warlisttemplate', '', 'default', 'string' );
		$wartemplateName = JRequest::getVar( 'wartemplate', '', 'default', 'string' );
		
		$items = $this->get('Items');	
		$pagination	= $this->get('Pagination');	
		$state = $this->get('State');	
		$summary = $this->get('Summary');
		$canAddWars = $this->get('CanAddWars');
		
		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('state', $state);
		$this->assignRef('summary', $summary);
		$this->assignRef('canAddWars',$canAddWars);
		
		$this->assignRef('warlisttemplateName',$warlisttemplateName);
		$this->assignRef('wartemplateName',$wartemplateName);
		
		$params = &$state->params;
		$this->assignRef('params',$params);
		
		parent::display($tpl);
	}
}
