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
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';	

class SquadManagementModelChallenge extends JModelForm
{
	protected function populateState()
	{		
		$params = JFactory::getApplication()->getParams();
		$this->setState('params', $params);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.challenge', 'challenge', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		return $form;
	}
	
	protected function loadFormData()
	{
		$data = (array)JFactory::getApplication()->getUserState('com_squadmanagement.challenge.data', array());
		return $data;
	}
	
	public function getOpponentList($namepart)
	{
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__squad_opponent WHERE published = 1 AND name like '%".$namepart."%' order by name";
		
		$db->setQuery($query,0,10); 
		return $db->loadObjectList();
	}
	
	public function insertItem($data)
	{			
		// set the data into a query to update the record
		$db	= JFactory::getDBO();
		
		// try to find the opponent
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__squad_opponent');
		$query->where('url = '. $db->Quote($data['opponenturl']));
		$db->setQuery($query);
		$opponentFound = $db->loadObject();
		
		if ($opponentFound && trim($data['opponenturl']) != ''){
			$opponentid = $opponentFound->id;
		}
		else
		{
			// create a new opponent
			$opponent =new stdClass();
			$opponent->id = NULL;
			$opponent->name = $data['opponent'];
			$opponent->url = $data['opponenturl'];			
			
			$user = JFactory::getUser();
			if ($user->guest)
			{
				$opponent->contact = $data['contact'];
				$opponent->contactemail = $data['contactemail'];
			}
			else
			{
				$opponent->contact = $user->name;
				$opponent->contactemail = $user->email;
			}
			
			$db->insertObject('#__squad_opponent', $opponent);		
			$opponentid = $db->insertid();
		}
		
		$data['opponentid'] = $opponentid;
		
		$challenge =new stdClass();
		$challenge->id = NULL;
		$challenge->wardatetime = $data['wardatetime'];
		$challenge->state = 2;
		$challenge->squadid = $data['squadid'];
		$challenge->opponentid = $opponentid;
		$challenge->leagueid = $data['leagueid'];
		$challenge->challengedescription = $data['description'];
		$challenge->published = 0;

		$db = JFactory::getDBO();
		$db->insertObject('#__squad_war', $challenge);
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		}
		
		$params = JComponentHelper::getParams( 'com_squadmanagement' );
		
		$enablefightusmail = $params->get('enablefightusmail','1');
		if ($enablefightusmail == 1)
		{			
			SquadmanagementHelper::sendFightUsMail($data,$opponent,$params);
		}
		
		$enableforummessage = $params->get('enablefightuskunenaforummessage','1');
		if ($enableforummessage == 1)
		{
			SquadmanagementHelper::sendFightUsKunenaPost($data,$opponent,$params);
		}
		
		return true;
	}
}
