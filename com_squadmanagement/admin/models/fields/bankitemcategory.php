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

class JFormFieldBankItemCategory extends JFormFieldList
{
	protected $type = 'BankItemCategory';

	protected function getOptions() 
	{
		$params = JComponentHelper::getParams('com_squadmanagement');
		$categories =  $params->get('bankitemsubjects','');

		$list = explode("\n", $categories);
				
		$options = array();		

		foreach ($list as $item)
		{
			$options[] = JHtml::_('select.option', $item, $item);
		}
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>