<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squad Management!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2014 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.larshildebrandt.de
# Technical Support:  Forum - http://www..larshildebrandt.de/forum/
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

class SquadManagementController extends JControllerLegacy
{
	function removemember($id,$squadid)
	{
		$model = $this->getModel('squad');
		$squadid = $model->getData($squadid);

		$user = JFactory::getUser();
		$userid = $user->get('id');
		if ($userid != $squadid->squadleader)
		{			
			return false;
		}		
		
		$query = 'DELETE FROM #__squad_member WHERE id = '.$id;

		$db = JFactory::getDBO();
		$db->setQuery($query);
		
		return $db->query();
		
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=editsquad&format=message' );
	}
	
	function addmember($userid,$squadid,$role)
	{
		$model = $this->getModel('squad');
		$squad = $model->getData($squadid);

		$currentuser = JFactory::getUser();
		$currentuserid = $currentuser->get('id');
		if ($currentuserid != $squad->squadleader)
		{			
			return false;
		}		
		
		$member =new stdClass();
		$member->id = null;
		$member->userid = $userid;
		$member->squadid = $squadid;
		$member->memberstate = 2; // Fullmember
		$member->role = $role;
		$member->published = 1;

		$db = JFactory::getDBO();
		$db->insertObject( '#__squad_member', $member );
		
		$memberModel = $this->getModel('squadmember');

		$table = $memberModel->getTable('squadmember');
		$table->reorder();	
		
		if (!$this->hasMemberAdditionalInfoEntry($userid))
		{
			$memberimage = new stdClass();
			$memberimage->id = null;
			$memberimage->userid = $userid;
			$memberimage->imageurl = null;
			
			$db = JFactory::getDBO();
			$db->insertObject( '#__squad_member_additional_info', $memberimage );				
		}
		
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=editsquad&format=message' );
	}
	
	function hasMemberAdditionalInfoEntry($userid)
	{
		$db = JFactory::getDBO();
		$select = '* ';
		$from = '#__squad_member_additional_info ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE userid = " . $userid;
		
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		
		return count($result) == 1;
	}
	
	function removewarround($id)
	{
		$query = 'DELETE FROM #__squad_war_round WHERE id = '.$id;

		$db = JFactory::getDBO();
		$db->setQuery($query);
		
		if (!$db->query()) 
		{
			return $db->getErrorMsg(true);
		}		
		
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=editsquad&format=message' );
	}	
	
	function savewarround($warid,$map,$mapimage,$screenshot,$score,$scoreopponent)
	{
		if ($warid == -1)
		{
			return;	
		}
		
		if ($screenshot != '')
		{
			$parts = pathinfo(JURI::root().$screenshot);		
			
			// Resize Image
			$resizer = new ImageResizer();
			$resizer->load(JURI::root().$screenshot);
			$resizer->resizeToWidth(600);
			$resizer->save('../images/squadmanagement/warscreenshots/thumbs/'.$parts['basename']);				
		}			
		
		$round = new stdClass();
		$round->id = null;
		$round->warid = $warid;
		$round->map = $map;
		$round->mapimage = $mapimage;
		$round->score = $score;
		$round->score_opponent = $scoreopponent;
		$round->screenshot = $screenshot;
		
		$db = JFactory::getDBO();
		$db->insertObject( '#__squad_war_round', $round );		

		$this->setRedirect( 'index.php?option=com_squadmanagement&view=editsquad&format=message' );		
	}	
	
	function saveopponent($name, $logo, $contact, $contactemail, $url)
	{	
		$round = new stdClass();
		$round->id = null;
		$round->name = $name;
		$round->logo = $logo;
		$round->contact = $contact;
		$round->contactemail = $contactemail;
		$round->url = $url;
		
		$db = JFactory::getDBO();
		$db->insertObject( '#__squad_opponent', $round );		
		
		$newId = $db->insertid();
		
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=editsquad&format=message' );
		
		return $newId;		
	}	
	
	function deleteappointment($id)
	{		
		$db = JFactory::getDBO();
		
		$query = 'DELETE FROM #__squad_appointment_member WHERE appointmentid = '.$id;
		$db->setQuery($query);	
		
		if (!$db->query()) 
		{
			return $db->getErrorMsg(true);
		}		
		
		$query = 'DELETE FROM #__squad_appointment WHERE id = '.$id;
		$db->setQuery($query);
		
		if (!$db->query()) 
		{
			return $db->getErrorMsg(true);
		}		
		
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=editsquad&format=message' );	
	}
	
	function addtoappointment($id)
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');		
		
		$db = JFactory::getDbo();			
		$query = $db->getQuery(true);
		$query->insert('#__squad_appointment_member');
		$query->set('appointmentid = '.$db->quote($id));
		$query->set('userid = '.$db->quote($userid));
		
		$db->setQuery($query);
		
		if (!$db->query()) 
		{
			return $db->getErrorMsg(true);
		}		
		
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=editsquad&format=message' );	
	}
	
	function removefromappointment($id)
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');	
		
		$query = 'DELETE FROM #__squad_appointment_member WHERE appointmentid = '.$id.' AND userid = '.$userid;

		$db = JFactory::getDBO();
		$db->setQuery($query);
		
		if (!$db->query()) 
		{
			return $db->getErrorMsg(true);
		}		
		
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=editsquad&format=message' );	
	}
}
