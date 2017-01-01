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

class JFormFieldLeagueAll extends JFormFieldList
{
	protected $type = 'Leagueall';

	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,name ');
		$query->from('#__squad_league');
		$query->where('published = 1');
		$query->order('name');
		
		$db->setQuery((string)$query);
		$leagues = $db->loadObjectList();
		$options = array();
		if ($leagues)
		{
			foreach($leagues as $league) 
			{
				$options[] = JHtml::_('select.option', $league->id, $league->name);
			}
		}
		
		array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_SQUADMANAGEMENT_ALL_LEAGUES')));
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>