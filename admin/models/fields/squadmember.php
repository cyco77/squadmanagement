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

class JFormFieldSquadmember extends JFormFieldList
{
	protected $type = 'Squadmember';

	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('m.userid, u.name');
		$query->where('published = 1');
		$query->from('#__users u INNER JOIN #__squad_member m ON u.id = m.userid');
		$query->group('m.userid, u.name');
		$db->setQuery((string)$query);
		$members = $db->loadObjectList();
		$options = array();
		if ($members)
		{
			foreach($members as $member) 
			{
				$options[] = JHtml::_('select.option', $member->userid, $member->name);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>