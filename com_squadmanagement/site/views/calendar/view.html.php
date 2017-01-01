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

class SquadManagementViewCalendar extends JViewLegacy
{
	function display($tpl = null) 
	{
		$wartemplateName = JRequest::getVar( 'wartemplate', '', 'default', 'string' );
		
		$month = ( int ) date( "m" );
		$year = date( "Y" ); 

		$newmonth = JRequest::getVar( 'squadmanagementagendanewmonth', '', 'default', 'int' );
		$newyear = JRequest::getVar( 'squadmanagementagendanewyear', '', 'default', 'int' );

		if ($newmonth && $newyear)
		{
			$month = $newmonth;
			$year = $newyear;
		}
		
		$model = $this->getModel();
		$items = $model->getCalendarItems($year,$month);
		$appointments = $model->getSquadappointments($year,$month);
		$state = $this->get('State');	
		
		$this->assignRef('month', $month);
		$this->assignRef('year', $year);
		$this->assignRef('items', $items);
		$this->assignRef('appointments', $appointments);
		$this->assignRef('state', $state);
		
		$this->assignRef('wartemplateName',$wartemplateName);
		
		$params = &$state->params;
		$this->assignRef('params',$params);
		
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
			$this->params->def('page_heading', JText::_('COM_SQUADMANAGEMENT_CALENDAR_DEFAULT_PAGE_TITLE'));
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
