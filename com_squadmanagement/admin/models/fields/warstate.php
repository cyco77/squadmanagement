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

class JFormFieldWarState extends JFormFieldList
{
	protected $type = 'WarState';

	protected function getOptions() 
	{
		$options = array();

		$options[] = JHtml::_('select.option', 0, JText::_('ALL_SQUADMANAGEMENT_WARS_STATE_SCHEDULED'));
		$options[] = JHtml::_('select.option', 1, JText::_('ALL_SQUADMANAGEMENT_WARS_STATE_PLAYED'));
		$options[] = JHtml::_('select.option', 2, JText::_('ALL_SQUADMANAGEMENT_WARS_STATE_CHALLENGED'));
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>