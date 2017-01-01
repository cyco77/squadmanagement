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

// import Joomla modelitem library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'imagehelper.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		

class SquadManagementModelEditAppointment extends JModelForm
{
	public function getTable($type = 'Appointment', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.editappointment', 'editappointment', array('control' => 'jform', 'load_data' => $loadData));
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
			$id = JRequest::getVar( 'id', '', 'default', 'int' );

			$data = $this->getData($id);
		}
		return $data;
	}
	
	public function getData($id)
	{						
		if (empty( $this->_data )) {
			$query = ' SELECT a.id, a.type, a.startdatetime, a.enddatetime, a.subject, a.body, a.duration, a.published, a.ordering, a.squadid, s.name as squadname, s.image as squadimage'.
				' FROM #__squad_appointment a INNER JOIN #__squad s ON s.id = a.squadid' .
				' WHERE a.id = '.$id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		
		return $this->_data;
	}
			
	public function addItem($data)
	{
		$db = JFactory::getDbo();			
		$query = $db->getQuery(true);
		$query->insert('#__squad_appointment');
		$query->set('startdatetime = '.$db->quote($data['startdatetime']));
		$query->set('enddatetime = '.$db->quote($data['enddatetime']));
		$query->set('type = '.$db->quote($data['type']));
		$query->set('squadid = '.$db->quote($data['squadid']));
		$query->set('duration = '.$db->quote($data['duration']));
		$query->set('subject = '.$db->quote($data['subject']));
		$query->set('body = '.$db->quote($data['body']));
		$query->set('published = '.$db->quote(1));		
		
		$db->setQuery($query);
		
		$result = $db->query();
		$newId = $db->insertid();
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return -1;
		} 
		else 
		{
			return $newId;
		}
	}
	
	public function updateItem($data)
	{
		$db = JFactory::getDbo();		
		$query = $db->getQuery(true);
		$query->update('#__squad_appointment');
		$query->set('startdatetime = '.$db->quote($data['startdatetime']));
		$query->set('enddatetime = '.$db->quote($data['enddatetime']));
		$query->set('type = '.$db->quote($data['type']));
		$query->set('squadid = '.$db->quote($data['squadid']));
		$query->set('duration = '.$db->quote($data['duration']));
		$query->set('subject = '.$db->quote($data['subject']));
		$query->set('body = '.$db->quote($data['body']));
		$query->set('published = '.$db->quote(1));

		$query->where('id = ' . (int)$data['id']);
		$db->setQuery($query);
		
		$result = $db->query();
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} 
		else 
		{
			return true;
		}
	}
}

?>