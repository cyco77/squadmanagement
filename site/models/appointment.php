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

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'imagehelper.php');

class SquadManagementModelAppointment extends JModelAdmin
{
	public function getTable($type = 'Appointment', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.appointment', 'appointment', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_squadmanagement.edit.appointment.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();			
		}
		
		return $data;
	}
	
	function getData($id)
	{
		$query = 'SELECT a.id, a.type, a.startdatetime, a.enddatetime, a.duration, a.subject, a.body, a.published, a.ordering, a.squadid, s.name as squadname, s.icon as squadimage';
		
		$query .= ' FROM #__squad_appointment a';
		$query .= ' INNER JOIN #__squad s ON s.id = a.squadid';
		$query .= ' WHERE a.id = '.$id;
		
		$db = $this->getDbo();
		
		$db->setQuery($query); 
		$result = $db->loadObject();
		
		$result->members = $this->getMembers($id);		
		
		return $result;
	}	
	
	function getMembers($id)
	{
		$avatarjoin = IntegrationHelper::getAvatarSqlJoin('m');
		$avatarselect = IntegrationHelper::getAvatarSqlSelect();
		
		$membernameField = IntegrationHelper::getMembernameField();
		
		$db = JFactory::getDBO();
		
		$query = 'SELECT m.id, '.$membernameField.', u.id as userid, m.state '.$avatarselect;
				
		$query .= ' FROM #__squad_appointment_member m ';
		$query .= ' INNER JOIN #__users u ON m.userid = u.id ';
		$query .= ' LEFT OUTER JOIN #__squad_member_additional_info i ON m.userid = i.userid '.$avatarjoin;
		$query .= ' WHERE m.appointmentid = ' . $id;
		
		$db->setQuery($query);
		
		return $db->loadObjectList();
	}
}
