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

class JFormFieldAdditionalFieldType extends JFormFieldList
{
	protected $type = 'AdditionalFieldType';

	protected function getOptions() 
	{
		$options = array();		

		$options[] = JHtml::_('select.option', "text", 'Text');
		$options[] = JHtml::_('select.option', "number", 'Number');
		$options[] = JHtml::_('select.option', "date", 'Date');
		$options[] = JHtml::_('select.option', "icq", 'ICQ');
		$options[] = JHtml::_('select.option', "skype", 'Skype');
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>