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

class JFormFieldAdditionalTab extends JFormFieldList
{
	protected $type = 'AdditionalTab';

	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,name,ordering,published');
		$query->where('published = 1');
		$query->from('#__squad_member_additional_tab');
		$query->order('name');
		$db->setQuery((string)$query);
		$tabs = $db->loadObjectList();
		$options = array();
		if ($tabs)
		{
			$options[] = JHtml::_('select.option', -1, JText::_('COM_SQUADMANAGEMENT_TAB_COMMON'));
			
			foreach($tabs as $tab) 
			{
				$options[] = JHtml::_('select.option', $tab->id, $tab->name);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>