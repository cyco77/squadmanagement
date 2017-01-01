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

class JFormFieldMemberState extends JFormFieldList
{
	protected $type = 'MemberState';

	protected function getOptions() 
	{
		$options = array();

		$options[] = JHtml::_('select.option', 0, JText::_('ALL_SQUADMANAGEMENT_MEMBER_STATE_JOINREQUEST'));
		$options[] = JHtml::_('select.option', 1, JText::_('ALL_SQUADMANAGEMENT_MEMBER_STATE_TRIAL'));
		$options[] = JHtml::_('select.option', 2, JText::_('ALL_SQUADMANAGEMENT_MEMBER_STATE_FULLMEMBER'));
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>