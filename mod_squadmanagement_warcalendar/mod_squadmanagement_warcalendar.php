<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.helper' );

// get this month and this years as an int
$month = ( int ) date( "m" );
$year = date( "Y" ); 

$newmonth = JRequest::getVar( 'squadmanagementmodulenewmonth', '', 'default', 'int' );
$newyear = JRequest::getVar( 'squadmanagementmodulenewyear', '', 'default', 'int' );

if ($newmonth && $newyear)
{
	$month = $newmonth;
	$year = $newyear;
}

$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select('w.id, w.wardatetime, w.state, w.squadid, s.name as squad, s.icon as squadlogo, o.name as opponent, o.logo as opponentlogo, l.name as league, w.score, w.scoreopponent');

$query->from('#__squad_war w INNER JOIN #__squad s ON w.squadid = s.id INNER JOIN #__squad_opponent o ON w.opponentid = o.id INNER JOIN #__squad_league l ON w.leagueid = l.id');

$query->where('w.state in (0,1) AND w.published = 1 AND MONTH(w.wardatetime) = '.$month.' AND YEAR(w.wardatetime) = '.$year);

$db->setQuery($query);      
	
$wars = $db->loadObjectList();

require(JModuleHelper::getLayoutPath('mod_squadmanagement_warcalendar'));