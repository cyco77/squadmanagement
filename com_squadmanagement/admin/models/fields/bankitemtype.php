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

class JFormFieldBankItemType extends JFormFieldList
{
	protected $type = 'BankItemType';

	protected function getOptions() 
	{
		$options = array();		

		$options[] = JHtml::_('select.option', 1, JText::_('ALL_SQUADMANAGEMENT_BANKITEMTYPE_INCOMING'));
		$options[] = JHtml::_('select.option', -1, JText::_('ALL_SQUADMANAGEMENT_BANKITEMTYPE_OUTGOING'));
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>