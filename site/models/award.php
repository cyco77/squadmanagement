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

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

class SquadManagementModelAward extends JModelAdmin
{
	public function getTable($type = 'Award', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.award', 'award', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_squadmanagement.edit.award.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();			
		}
		
		return $data;
	}
	
	function getData($id)
	{
		$query = 'SELECT a.id, a.name, a.awarddate, a.place, a.url, a.imageurl, a.description, a.published, a.ordering, a.squadid, s.name as squadname, s.icon as squadimage';
		
		$query .= ' FROM #__squad_award a';
		$query .= ' INNER JOIN #__squad s ON s.id = a.squadid';
		$query .= ' WHERE a.id = '.$id;
		
		$db = $this->getDbo();
		
		$db->setQuery($query); 
		$result = $db->loadObject();
				
		return $result;
	}	
}
