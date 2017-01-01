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

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'script'.DIRECTORY_SEPARATOR.'steam'.DIRECTORY_SEPARATOR.'SteamUtility.php';		
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'script'.DIRECTORY_SEPARATOR.'steam'.DIRECTORY_SEPARATOR.'SteamUser.php';		

class IntegrationHelper  
{	
	static function isKunenaAvailable()
	{
		return true;
	}
	
	static function isCbAvailable()
	{
		return true;	
	}
	
	static function isCbeAvailable()
	{
		return true;	
	}

	static function isSteamAvailable()
	{
		return true;	
	}

	public static function getAvatarSqlJoin($usertableShortcut = 'm')
	{
		$params = JComponentHelper::getParams('com_squadmanagement');
		
		switch ($params->get( 'integration_avatarsource' , 0))
		{
			case 1:
				if (IntegrationHelper::isKunenaAvailable()) 
				{ 
					return ' LEFT OUTER JOIN #__kunena_users a ON '.$usertableShortcut.'.userid = a.userid ';
				}
				break;	
			case 2:
				return '';
			case 3:
				if (IntegrationHelper::isCbAvailable()) 
				{ 
					return ' LEFT OUTER JOIN #__comprofiler a ON '.$usertableShortcut.'.userid = a.user_id ';
				}
				break;
			case 4:
				if (IntegrationHelper::isCbeAvailable()) 
				{ 
					return ' LEFT OUTER JOIN #__cbe_users a ON '.$usertableShortcut.'.userid = a.userid ';
				}
				break;
			default:
				return '';
		}	
	}
	
	public static function getAvatarSqlSelect()
	{
		$params = JComponentHelper::getParams('com_squadmanagement');
		
		switch ($params->get( 'integration_avatarsource' , 0))
		{
			case 1:
				if (IntegrationHelper::isKunenaAvailable()) 
				{ 
					return ' , a.avatar as avatar ';	
				}
				break;	
			case 2:
				return ' , u.email as avatar ';
				break;	
			case 3:
				if (IntegrationHelper::isCbAvailable()) 
				{ 
					return ' , a.avatar as avatar ';	
				}
				break;	
			case 4:
				if (IntegrationHelper::isCbAvailable()) 
				{ 
					return ' , a.avatar as avatar ';	
				}
				break;
			case 5:
				if (IntegrationHelper::isSteamAvailable()) 
				{ 
					return ' , i.steamid as avatar ';	
				}
				break;
			default:
				return ', i.imageurl as avatar ';
		}		
	}
	
	public static function getFullAvatarImagePath($imageurl)
	{
		if ($imageurl == '')
		{
			return JURI::root().'components/com_squadmanagement/images/unknownuser.jpg';
		}
		
		$params = JComponentHelper::getParams('com_squadmanagement');
		
		switch ($params->get( 'integration_avatarsource' , 0))
		{
			case 1:
				// Kunena
				return JURI::root().'media/kunena/avatars/'.$imageurl;
			case 2:
				// Gravatar
				$imagename = md5(strtolower(trim($imageurl)));
				return 'http://www.gravatar.com/avatar/'.$imagename.'?s=200';
			case 3:
				// CommunityBuilder
				return JURI::root().'images/comprofiler/'.$imageurl;
			case 4:
				// Community Builder Exchange
				return JURI::root().$imageurl;
			case 5:
				// Steam				
				$steamId64 = SteamUtility::steamIdToSteamId64($imageurl);
				
				$steamData = new SteamUser($steamId64);
				
				return $steamData->avatarMedium;		
			default:
				return JURI::root().$imageurl;
		}			
	}
	
	public static function getProfileLink($userid)
	{
		$params = JComponentHelper::getParams('com_squadmanagement');
		
		switch ($params->get( 'integration_profile' , 0))
		{
			case 1:
				// Kunena
				return JRoute::_( 'index.php?option=com_kunena&userid='.$userid.'&view=user');
			case 2:
				// CommunityBuilder
				return JRoute::_( 'index.php?option=com_comprofiler&task=userprofile&user='. $userid );
			case 3:
				// Community Builder Exchange
				return JRoute::_( 'index.php?option=com_cbe&view=profile&userid='. $userid );
			default:
				return JRoute::_( 'index.php?option=com_squadmanagement&amp;view=squadmember&amp;id='. $userid );
		}
	}
	
	public static function getMembernameField()
	{
		$params = JComponentHelper::getParams('com_squadmanagement');
		
		switch ($params->get( 'usedisplayname' , 1))
		{
			case 1:
				// SquadManagement
				return ' i.displayname as membername ';
			case 2:
				// Joomla Username
				return ' u.name as membername ';
			case 3:
				// Joomla Username
				return ' u.username as membername ';
			default:
				return ' i.displayname as membername ';
		}
	}
}

?>