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

class SquadManagementViewBankItems extends JViewLegacy
{
	function display($tpl = null) 
	{
		$items = $this->get('Items');			
		$sum = $this->get('Sum');
		$pagination	= $this->get('Pagination');	
		$state = $this->get('State');	
		
		$duesByMembers = $this->get('DuesByMembers');		
		$min = $this->getMinPayedTo($duesByMembers);
		$max = $this->getMaxPayedTo($duesByMembers);		
		
		$this->assignRef('items', $items);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('state', $state);
		$this->assignRef('sum', $sum);
		
		$this->assignRef('duesByMembers', $duesByMembers);
		$this->assignRef('min', $min);		
		$this->assignRef('max', $max);
		
		$params = &$state->params;
		$this->assignRef('params',$params);	
				
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
			$this->params->def('page_heading', JText::_('COM_SQUADMANAGEMENT_BANKITEMS_DEFAULT_PAGE_TITLE'));
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
	
	function getMinPayedTo($items)
	{
		$min = date("Y-m-d", strtotime("-1 months"));
		
		foreach($items as $member)
		{
			if (isset($member->payedto) && $member->payedto != '0000-00-00' && $member->payedto < $min)
			{
				$min = date($member->payedto);
			}		
		}	
		
		return $min;
	}
	
	function getMaxPayedTo($items)
	{
		$max = date("Y-m-d");
		
		foreach($items as $member)
		{
			if (isset($member->payedto) && $member->payedto != '0000-00-00' && $member->payedto > $max)
			{
				$max = date($member->payedto);
			}		
		}	
	}	
}
