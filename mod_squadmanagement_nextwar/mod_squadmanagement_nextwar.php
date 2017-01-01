<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.helper' );

$db = JFactory::getDBO();

$query = ' SELECT w.id, w.wardatetime, o.name AS opponent, o.logo AS opponentlogo, s.name AS squad, s.icon as squadlogo, l.name AS league';
$query .= ' FROM #__squad_war w';
$query .= ' INNER JOIN #__squad s ON w.squadid = s.id';
$query .= ' INNER JOIN #__squad_league l ON w.leagueid = l.id';
$query .= ' INNER JOIN #__squad_opponent o ON w.opponentid = o.id';
$query .= ' WHERE w.wardatetime > current_date( ) AND w.state = 0';
$query .= ' ORDER BY w.wardatetime';  
$query .= ' LIMIT 1';

$db->setQuery($query);      

$item = $db->loadObject();

require(JModuleHelper::getLayoutPath('mod_squadmanagement_nextwar'));