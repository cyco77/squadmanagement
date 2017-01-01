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
	
	public function save($data)
	{		
		$isRecurringAppointment = $_POST["isrecurringappointment"];
		
		$result = parent::save($data);	
		
		if(isset($isRecurringAppointment) && $isRecurringAppointment == 'Yes')
		{		
			$data['id'] = null;	
			$appointmentCount = $_POST["recurrence_count"];
			$frequency = $_POST["recurrence_frequency"];
			
			for ($i = 1; $i <= $appointmentCount; $i++) {
				
				switch ($frequency)
				{
					case 1:
						$data['startdatetime'] = $this->getNewDateAfterAddingDays($data['startdatetime'],7);						
						break;
					case 2:	
						$data['startdatetime'] = $this->getNewDateAfterAddingMonths($data['startdatetime'],1);
						break;
					case 3:
						$data['startdatetime'] = $this->getNewDateAfterAddingYears($data['startdatetime'],1);
						break;
				}
				
				$this->saveAppointment($data);
			}
		}		
		
		if ($data->ordering < 1)
		{
			$table = $this->getTable();
			$table->reorder();	
		}
		
		return $result;
	}
	
	function saveAppointment($data)
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
	
	function getNewDateAfterAddingDays($day,$days)
	{
		return date('Y-m-d H:i:s', strtotime($day. ' + '.$days.' days'));
	}
	
	function getNewDateAfterAddingYears($day,$years)
	{
		return date('Y-m-d H:i:s', strtotime($day. ' + '.$years.' years'));
	}
	
	function getNewDateAfterAddingMonths($day,$monthToAdd)
	{
		$d1 = DateTime::createFromFormat('Y-m-d H:i:s', $day);

		$year = $d1->format('Y');
		$month = $d1->format('n');
		$day = $d1->format('d');

		$year += floor($monthToAdd/12);
		$monthToAdd = $monthToAdd%12;
		$month += $monthToAdd;
		if($month > 12) 
		{
			$year ++;
			$month = $month % 12;
			if($month === 0)
			{
				$month = 12;
			}
		}

		if(!checkdate($month, $day, $year)) 
		{
			$d2 = DateTime::createFromFormat('Y-n-j', $year.'-'.$month.'-1');
			$d2->modify('last day of');
		}
		else 
		{
			$d2 = DateTime::createFromFormat('Y-n-d', $year.'-'.$month.'-'.$day);
		}
		
		$d2->setTime($d1->format('H'), $d1->format('i'), $d1->format('s'));
		
		return $d2->format('Y-m-d H:i:s');
	}
}
