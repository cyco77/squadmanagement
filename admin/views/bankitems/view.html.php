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

class SquadManagementViewBankItems extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;
	
	protected $sum;
	
	var $canDo;
	
	function display($tpl = null) 
	{
		$this->canDo = SquadmanagementHelper::getActions();
		if (!$this->canDo->get('com_squadmanagement.bankitem')) 
		{
			return JError::raiseWarning( 500, JText::_( 'COM_SQUADMANAGEMENT_NOACCESS' ) );
		}		
		
		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->sum = $this->get('Sum');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Preprocess the list of items to find ordering divisions.
		// TODO: Complete the ordering stuff with nested sets
		foreach ($this->items as &$item) {
			$item->order_up = true;
			$item->order_dn = true;
		}

		// Set the toolbar
		$this->addToolBar();		
		$this->sidebar = JHtmlSidebar::render();

		// Display the template
		parent::display($tpl);
	}

	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_SQUADMANAGEMENT_MANAGER_BANKITEMS'),'bankitems');
		if ($this->canDo->get('core.create')) 
		{	
			JToolBarHelper::addNew('bankitem.add');
		}
		
		if ($this->canDo->get('core.edit')) 
		{
			JToolBarHelper::editList('bankitem.edit');
		}
		
		if ($this->canDo->get('core.edit.state')) 
		{
			JToolBarHelper::divider();
			JToolBarHelper::publishList('bankitems.publish');
			JToolBarHelper::unpublishList('bankitems.unpublish');			
		}
		
		if ($this->canDo->get('core.delete')) 
		{			
			JToolBarHelper::divider();
			JToolBarHelper::deleteList('', 'bankitems.delete');
		}		
		
		if ($this->canDo->get('core.admin')) 
		{	
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_squadmanagement',520,650);
		}
		
		JHtmlSidebar::setAction('index.php?option=com_squadmanagement&view=bankitems');
		
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);		
	}
	
	protected function getSortFields()
	{
		return array(
			'b.subject' => JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_SUBJECT'),
			'b.itemdatetime' => JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_ITEMDATETIME'),
			'b.amount' => JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_AMOUNT'),
			'b.type' => JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_TYPE'),
			'membername' => JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_USER')
			);
	}
}
