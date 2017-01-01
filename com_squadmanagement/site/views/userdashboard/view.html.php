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

class SquadManagementViewUserDashboard extends JViewLegacy
{
	function display($tpl = null) 
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		if ($userid == 0)
		{			
			parent::display('noaccess');
			return false;
		}		
		
		$templateName = JRequest::getVar( 'userdashboardtemplate', '', 'default', 'string' );
		$state = $this->get('State');	
		$memberInfo = $this->get('MemberInfo');
		$lastBankItem = $this->get('LastBankItem');
		$bankItems = $this->get('BankItems');
		$appointments = $this->get('Appointments');		
		$wars = $this->get('Wars');	
		
		$this->assignRef('templateName', $templateName);
		$this->assignRef('state', $state);
		$this->assignRef('memberInfo', $memberInfo);
		$this->assignRef('lastBankItem', $lastBankItem);
		$this->assignRef('bankItems', $bankItems);
		$this->assignRef('appointments', $appointments);
		$this->assignRef('wars', $wars);
		
		$params = &$state->params;
		$this->assignRef('params',$params);	
		$usebank = $this->params->get('usebank', 0);
		$this->assignRef('usebank', $usebank);
				
		$this->_prepareDocument();
		
		parent::display($tpl);
	}
	
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
