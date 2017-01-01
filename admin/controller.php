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

// import Joomla controller library
jimport('joomla.application.component.controller');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'administrator/components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'imageresizer.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';	


class SquadManagementController extends JControllerLegacy
{
	function bankitemsmembers() 
	{
		$this->setRedirect("index.php?option=com_squadmanagement&view=bankitemsmembers");
	}

	function display($cachable = false, $urlparams = false) 
	{
		// Load the submenu.
		SquadmanagementHelper::addSubmenu(JRequest::getCmd('view', 'frontpage'));
		
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'Frontpage'));

		// call parent behavior
		parent::display($cachable);
	}
	
	function addmember($id)
	{
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=squad&layout=edit&id='.$id );
		
		$userid = JRequest::getVar('userid');
		$username = JRequest::getVar('username');
		$role = JRequest::getVar('role');
		
		if (!is_numeric($userid))
		{
			$msg = 'No UserID';
			
			$this->setMessage( $msg );
			return;	
		}
		
		$model = $this->getModel('squad');
		if (SquadmanagementHelper::isUserInSquad($userid, $id))
		{
			$msg = 'User allready in Squad';
		}
		else
		{			
			$member =new stdClass();
			$member->id = null;
			$member->userid = $userid;
			$member->squadid = $id;
			$member->memberstate = 2; // Fullmember
			$member->role = $role;
			$member->published = 1;

			$db = JFactory::getDBO();
			$db->insertObject( '#__squad_member', $member, id );
									
			$memberModel = $this->getModel('squadmember');

			$table = $memberModel->getTable('squadmember');
			$table->reorder();	
	
			if (!SquadmanagementHelper::hasMemberAdditionalInfoEntry($userid))
			{
				$memberimage = new stdClass();
				$memberimage->id = null;
				$memberimage->userid = $userid;
				$memberimage->imageurl = null;
				
				$db = JFactory::getDBO();
				$db->insertObject( '#__squad_member_additional_info', $memberimage, id );				
			}
			
			$msg = $role != '' ? 'Member: '.$username.' - Role: '.$role.' saved' : 'Member: '.$username.' saved';
		}
		
		$this->setMessage( $msg );
	}
	
	function removemember($id,$squadid)
	{
		$this->setRedirect( 'index.php?option=com_squadmanagement&view=squad&layout=edit&id='.$squadid );

		$query = 'DELETE FROM #__squad_member WHERE id = '.$id;

		$db = JFactory::getDBO();
		$db->setQuery($query);
		
		if (!$db->query()) 
		{
			$msg = $db->getErrorMsg(true);
		}
		else
		{
			$msg = 'Member removed';	
		}				
		
		$this->setMessage( $msg );
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
	}	

	function savewarround($warid,$map,$mapimage,$screenshot,$score,$scoreopponent)
	{
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
	}	
}
