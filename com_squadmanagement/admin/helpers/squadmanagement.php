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

class SquadmanagementHelper  {

	public static function addSubmenu($vName)
	{
		$canDo = SquadmanagementHelper::getActions();
		
		JHtmlSidebar::addEntry(
			JText::_('COM_SQUADMANAGEMENT_SUBMENU_FRONTPAGE'),
			'index.php?option=com_squadmanagement&view=frontpage',
			$vName == 'frontpage'
			);

		if ($canDo->get('com_squadmanagement.squad'))
		{

			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_CATEGORIES'),
				'index.php?option=com_categories&extension=com_squadmanagement',
				$vName == 'categories'
				);
			if ($vName == 'categories')
			{
				JToolbarHelper::title(
					JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('com_squadmanagement')),
					'squads-categories');
			}			

			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_SQUADS'),
				'index.php?option=com_squadmanagement&view=squads',
				$vName == 'squads'
				);

			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_SQUADMEMBERS'),
				'index.php?option=com_squadmanagement&view=squadmembers',
				$vName == 'squadmembers'
				);

		}
		
		if ($canDo->get('com_squadmanagement.field'))
		{
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_TABS'),
				'index.php?option=com_squadmanagement&view=additionaltabs',
				$vName == 'additionaltabs'
				);
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_FIELDS'),
				'index.php?option=com_squadmanagement&view=additionalfields',
				$vName == 'additionalfields'
				);
			
		}
		
		if ($canDo->get('com_squadmanagement.league'))
		{		
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_LEAGUES'),
				'index.php?option=com_squadmanagement&view=leagues',
				$vName == 'leagues'
				);

		}
		
		if ($canDo->get('com_squadmanagement.opponent'))
		{
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_OPPONENTS'),
				'index.php?option=com_squadmanagement&view=opponents',
				$vName == 'opponents'
				);

		}
		
		if ($canDo->get('com_squadmanagement.war'))
		{
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_WARS'),
				'index.php?option=com_squadmanagement&view=wars',
				$vName == 'wars'
				);
			
		}
		
		if ($canDo->get('com_squadmanagement.appointment'))
		{		
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_APPOINTMENTS'),
				'index.php?option=com_squadmanagement&view=appointments',
				$vName == 'appointments'
				);

		}
		
		if ($canDo->get('com_squadmanagement.award'))
		{
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_AWARDS'),
				'index.php?option=com_squadmanagement&view=awards',
				$vName == 'awards'
				);
			
		}
		
		if ($canDo->get('com_squadmanagement.bankitem'))
		{
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_BANKITEMS'),
				'index.php?option=com_squadmanagement&view=bankitems',
				$vName == 'bankitems'
				);
			
			JHtmlSidebar::addEntry(
				JText::_('COM_SQUADMANAGEMENT_SUBMENU_BANKITEMSMEMBER'),
				'index.php?option=com_squadmanagement&view=bankitemsmembers',
				$vName == 'bankitemsmembers'
				);
		}
	}
	
	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId))
		{
			$assetName = 'com_squadmanagement';
			$level = 'component';
		}
		else
		{
			$assetName = 'com_squadmanagement.category.'.(int) $categoryId;
			$level = 'category';
		}

		$actions = JAccess::getActions('com_squadmanagement', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}

	public static function hasMemberAdditionalInfoEntry($userid)
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
	
	public static function isUserInSquad($userid,$squadid)
	{
		$db = JFactory::getDBO();
		$select = '* ';
		$from = '#__squad_member ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE userid = " . $userid . ' and squadid = ' . $squadid;
		
		$db->setQuery($query); 
		$result = $db->loadObjectList();
		
		return count($result) == 1;
	}
	
	public static function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
	
	public static function getDateDiff($date1,$date2)
	{
		$d1 = new DateTime($date1);
		$d2 = new DateTime($date2);

		$diff = $d2->diff($d1);

		return ($diff->format('%y') * 12) + $diff->format('%m');
	}	

	
	public static function sendJoinUsMail($joinus,$params)
	{
		// Load Squad
		$squad = SquadmanagementHelper::loadSquad($joinus->squadid);
		
		$mailer =& JFactory::getMailer();
		// Set Sender
		$usersender =& JFactory::getUser();
		$sender = $usersender->email;
		$mailer->setSender($sender);
		// Set Recipient
		$user =& JFactory::getUser($squad->squadleader);
		$recipient = $user->email;
		$mailer->addRecipient($recipient);
		
		$joinusmailheader = $params->get('joinusmailheader','New Joinrequest');
		$joinusmailbody = $params->get('joinusmailbody','New Joinrequest');
		
		$joinusmailbody = str_replace('{squad}',$squad->name,$joinusmailbody);
		$joinusmailbody = str_replace('{user}',$usersender->username,$joinusmailbody);
		$joinusmailbody = str_replace('{message}',$joinus->joinusdescription,$joinusmailbody);
		
		$joinusmailheader = str_replace('{squad}',$squad->name,$joinusmailheader);
		$joinusmailheader = str_replace('{user}',$usersender->username,$joinusmailheader);
		
		$mailer->setSubject($joinusmailheader);
		$mailer->setBody($joinusmailbody);
		
		return $mailer->Send();
	}	
	
	public static function sendFightUsMail($data,$opponent,$params)
	{
		// Load Squad
		$squad = SquadmanagementHelper::loadSquad($data['squadid']);
		$league = SquadmanagementHelper::loadLeague($data['leagueid']);		
		$opponent = SquadmanagementHelper::loadOpponent($data['opponentid']);
		
		$mailer =& JFactory::getMailer();
		// Set Sender
		$usersender =& JFactory::getUser();
		$sender = $usersender->email;
		$mailer->setSender($sender);
		// Set Recipient
		$user =& JFactory::getUser($squad->squadleader);
		$recipient = $user->email;
		$mailer->addRecipient($recipient);
		
		if ($squad->waradmin != '')
		{
			$user =& JFactory::getUser($squad->waradmin);
			$recipient = $user->email;
			$mailer->addRecipient($recipient);	
		}
		
		$subject = $params->get('fightusmailheader','New Fight-Us Request');
		$message = $params->get('fightusmailbody','New Fight-Us Request');
		
		$subject = str_replace('{date}',$data['wardatetime'],$subject);
		$subject = str_replace('{squad}',$squad->name,$subject);
		$subject = str_replace('{contact}',$opponent->contact,$subject);
		$subject = str_replace('{clan}',$opponent->name,$subject);
		$subject = str_replace('{url}',$opponent->url,$subject);
		$subject = str_replace('{email}',$opponent->contactemail,$subject);
		$subject = str_replace('{league}',$league->name,$subject);
		
		$message = str_replace('{date}',$data['wardatetime'],$message);
		$message = str_replace('{squad}',$squad->name,$message);
		$message = str_replace('{contact}',$opponent->contact,$message);
		$message = str_replace('{clan}',$opponent->name,$message);
		$message = str_replace('{url}',$opponent->url,$message);
		$message = str_replace('{email}',$opponent->contactemail,$message);
		$message = str_replace('{league}',$league->name,$message);
		$message = str_replace('{message}',$data['description'],$message);	
		
		$mailer->setSubject($subject);
		$mailer->setBody($message);
		
		return $mailer->Send();
	}	
	
	public static function sendFightUsKunenaPost($data,$params)
	{
		jimport('joomla.application.component.helper');
		if(JComponentHelper::isEnabled('com_kunena', true)) {
			
			$squad = SquadmanagementHelper::loadSquad($data['squadid']);
			$league = SquadmanagementHelper::loadLeague($data['leagueid']);
			$opponent = SquadmanagementHelper::loadOpponent($data['opponentid']);
			
			$params = JComponentHelper::getParams( 'com_squadmanagement' );
			
			$botid = $params->get('fightuskunenaforumwriterid','0');
			$botname = $params->get('fightuskunenaforumwritername','System');
			$subject = $params->get('fightuskunenaforumpostsubject','New Fight!');
			$message = $params->get('fightuskunenaforumpostbody','New Fight!');
			$catid = $params->get('fightuskunenaforumcatid','0');				
			
			$subject = str_replace('{date}',$data['wardatetime'],$subject);
			$subject = str_replace('{squad}',$squad->name,$subject);
			$subject = str_replace('{contact}',$opponent->contact,$subject);
			$subject = str_replace('{clan}',$opponent->name,$subject);
			$subject = str_replace('{url}',$opponent->url,$subject);
			$subject = str_replace('{email}',$opponent->contactemail,$subject);
			$subject = str_replace('{league}',$league->name,$subject);
			
			$message = str_replace('{date}',$data['wardatetime'],$message);
			$message = str_replace('{squad}',$squad->name,$message);
			$message = str_replace('{contact}',$opponent->contact,$message);
			$message = str_replace('{clan}',$opponent->name,$message);
			$message = str_replace('{url}',$opponent->url,$message);
			$message = str_replace('{email}',$opponent->contactemail,$message);
			$message = str_replace('{league}',$league->name,$message);
			$message = str_replace('{message}',$data['description'],$message);			
			
			SquadmanagementHelper::saveKunenaPost($catid,$botid,$botname,$subject,$message);
		}
	}
	
	public static function sendJoinUsKunenaPost($data,$params)
	{
		jimport('joomla.application.component.helper');
		if(JComponentHelper::isEnabled('com_kunena', true)) {
			
			// Load Squad
			$squad = SquadmanagementHelper::loadSquad($data->squadid);
			$usersender =& JFactory::getUser();
			
			$botid = $params->get('joinuskunenaforumwriterid','0');
			$botname = $params->get('joinuskunenaforumwritername','System');
			$subject = $params->get('joinuskunenaforumpostsubject','New Join Request!');
			$message = $params->get('joinuskunenaforumpostbody','New Join Request!');
			$catid = $params->get('joinuskunenaforumcatid','0');
			
			$subject = str_replace('{squad}',$squad->name,$subject);
			$subject = str_replace('{user}',$usersender->username,$subject);
			
			$message = str_replace('{squad}',$squad->name,$message);
			$message = str_replace('{user}',$usersender->username,$message);
			$message = str_replace('{message}',$data->joinusdescription,$message);
			
			SquadmanagementHelper::saveKunenaPost($catid,$botid,$botname,$subject,$message);
		}
	}
	
	static function saveKunenaPost($catid, $botid, $botname, $subject, $message)
	{
		if (class_exists('Kunena')) {
			$time = CKunenaTimeformat::internalTime();
			$query = "INSERT INTO #__kunena_messages (catid,name,userid,email,subject,time, ip)
						VALUES({$catid},'{$botname}',{$botid}, '','{$subject}', {$time}, '')";
			$db->setQuery($query);
			if (!$db->query()) KunenaError::checkDatabaseError();
			$messid = (int)$db->insertID();
			$query = "INSERT INTO #__kunena_messages_text (mesid,message)
						VALUES({$messid},'{$message}')";
			$db->setQuery($query);
			if (!$db->query()) KunenaError::checkDatabaseError();
			$query = "UPDATE #__kunena_messages SET thread={$messid} WHERE id={$messid}";
			$db->setQuery($query);
			if (!$db->query()) KunenaError::checkDatabaseError();
			CKunenaTools::modifyCategoryStats($messid, 0, $time, $catid);
			$user['link'] = CKunenaLink::GetViewLink('view', $messid, $catid, '', $username);
			$uri = JFactory::getURI();
			if ($uri->getVar('option') == 'com_kunena') {
				$app = & JFactory::getApplication();
				$app->redirect($uri->toString());
			}
		} else {
			$_user = KunenaUserHelper::get($botid);
			$fields = array(
				'category_id' => (int)$catid,
				'name' => $_user->getName(''),
				'email' => null,
				'subject' => $subject,
				'message' => $message,
				'icon_id' => 0,
				'tags' => null,
				'mytags' => null,
				'subscribe' => 0,);
			$category = KunenaForumCategoryHelper::get((int)$catid);
			$app = JFactory::getApplication();
			if (!$category->exists()) {
				$app->setUserState('com_kunena.postfields', $fields);
				$app->enqueueMessage($category->getError(), 'notice');
			}
			if (!$category->authorise('topic.create', $_user)) {
				$app->setUserState('com_kunena.postfields', $fields);
				$app->enqueueMessage($category->getError(), 'notice');
			}
			list($topic, $message) = $category->newTopic($fields, $_user);
			$success = $message->save();
			if (!$success) {
				$app->enqueueMessage($message->getError(), 'error');
				$app->setUserState('com_kunena.postfields', $fields);
			}
			foreach ($message->getErrors() as $warning) {
				$app->enqueueMessage($warning, 'notice');
			}
		}
	}
	
	static function loadOpponent($opponentid)
	{
		$db = JFactory::getDBO();
		$select = '* ';
		$from = '#__squad_opponent ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE id = " . $opponentid;
		
		$db->setQuery($query); 
		$opponent = $db->loadObject();
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		}
		
		return $opponent;
	}
	
	static function loadLeague($leagueid)
	{
		$db = JFactory::getDBO();
		$select = '* ';
		$from = '#__squad_league ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE id = " . $leagueid;
		
		$db->setQuery($query); 
		$league = $db->loadObject();
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		}
		
		return $league;
	}
	
	static function loadSquad($squadid)
	{
		$db = JFactory::getDBO();
		$select = '* ';
		$from = '#__squad ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE id = " . $squadid;
		
		$db->setQuery($query); 
		$squad = $db->loadObject();
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		}
		
		return $squad;
	}
	
	public static function canAddAppointments()
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		if ($userid == 0)
		{
			return false;
		}
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');

		$query->from('#__squad s');
		
		$query->where('s.published = 1 AND (s.squadleader = '.$userid.' OR s.waradmin = '.$userid.')');
		
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		return count($result) > 0;
	}
	
	public static function canEditAppointments($squadid)
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		if ($userid == 0)
		{
			return false;
		}
		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');

		$query->from('#__squad s');
		
		$query->where('s.id = '.$squadid.' AND s.published = 1 AND (s.squadleader = '.$userid.' OR s.waradmin = '.$userid.')');
		
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		return count($result) > 0;
	}
	
	public static function isInSquad($squadid)
	{
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		$db = JFactory::getDBO();
		$select = '* ';
		$from = '#__squad_member ';
		$query = "SELECT   " . $select .
			"\n   FROM " . $from .
			"\n   WHERE userid = " . $userid . ' and squadid = ' . $squadid;
		
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		return count($result) == 1;
	}
}

?>