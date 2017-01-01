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

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldWarMemberState extends JFormFieldList
{
	protected $type = 'WarMemberState';

	protected function getOptions() 
	{
		$options = array();

		$options[] = JHtml::_('select.option', 0, JText::_('COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_UNKNOWN'));
		$options[] = JHtml::_('select.option', 1, JText::_('COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_YES'));
		$options[] = JHtml::_('select.option', 2, JText::_('COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_MAYBE'));
		$options[] = JHtml::_('select.option', 3, JText::_('COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_NO'));
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>