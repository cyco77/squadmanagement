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

class SquadManagementViewBankItemsMembers extends JViewLegacy
{
	function display($tpl = null) 
	{
		// Set the toolbar
		$this->addToolBar();	
		$this->sidebar = JHtmlSidebar::render();
		
		$model = $this->getModel();
		$items = $model->getMembers();

		$min = $this->getMinPayedTo($items);
		$max = $this->getMaxPayedTo($items);

		$this->assignRef('items', $items);		
		$this->assignRef('min', $min);		
		$this->assignRef('max', $max);		
		// Display the template
		parent::display($tpl);
	}

	protected function addToolBar() 
	{
		JHtmlSidebar::setAction('index.php?option=com_squadmanagement&view=bankitems');
		
		JToolBarHelper::title(JText::_('COM_SQUADMANAGEMENT_MANAGER_BANKITEMS'),'bankitems');		
			
		JToolBarHelper::preferences('com_squadmanagement',520,650);
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
		
		return $max;
	}
}
