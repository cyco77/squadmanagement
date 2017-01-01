<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.helper' );

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'script'.DIRECTORY_SEPARATOR.'steam'.DIRECTORY_SEPARATOR.'SteamUtility.php';		
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'script'.DIRECTORY_SEPARATOR.'steam'.DIRECTORY_SEPARATOR.'SteamUser.php';

$user = JFactory::getUser();

if (!$user->guest) {	
	$userid = $user->get('id');

	$db = JFactory::getDBO();

	// get userinfo
	$avatarjoin = IntegrationHelper::getAvatarSqlJoin('i');
	$avatarselect = IntegrationHelper::getAvatarSqlSelect();

	$membernameField = IntegrationHelper::getMembernameField();

	$query = ' SELECT '. $membernameField .', i.* '.$avatarselect.' FROM #__users u INNER JOIN #__squad_member_additional_info i ON u.id = i.userid '. $avatarjoin . '  WHERE i.userid = '.$userid;

	$db->setQuery($query);
	$member = $db->loadObject();	
}

require(JModuleHelper::getLayoutPath('mod_squadmanagement_profile'));

?>