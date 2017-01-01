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

class JFormFieldSquadAll extends JFormFieldList
{
	protected $type = 'SquadAll';

	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,icon,name,shortname,ordering,published ');
		$query->from('#__squad');
		$query->where('published = 1');
		$query->order('name');
		
		$db->setQuery((string)$query);
		$squads = $db->loadObjectList();
		$options = array();
		if ($squads)
		{
			foreach($squads as $squad) 
			{
				$options[] = JHtml::_('select.option', $squad->id, $squad->name);
			}
		}
		
		array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_SQUADMANAGEMENT_ALL_SQUADS')));
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>