<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.helper' );

$squadid = $params->get( 'squadid', '0' );
$state = $params->get( 'warstate', '0' );
$maxitemcount = $params->get( 'maxitemcount', 5);

$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select('w.id, w.wardatetime, w.state, w.squadid, s.name as squad, s.icon as squadlogo, o.name as opponent, o.logo as opponentlogo, l.name as league, w.score, w.scoreopponent');

$query->from('#__squad_war w INNER JOIN #__squad s ON w.squadid = s.id INNER JOIN #__squad_opponent o ON w.opponentid = o.id INNER JOIN #__squad_league l ON w.leagueid = l.id');

$where = 'w.state = ' . $state;

if (is_numeric($squadid) && $squadid > 0) {
	$where .= ' AND w.squadid = '.(int) $squadid;
}

$query->where($where);
$query->order('wardatetime ' . ($state == 1 ? 'desc' : ''));
$db->setQuery($query,0,$maxitemcount);
$warlist = $db->loadObjectList();

$document = JFactory::getDocument();

$cssHTML = JURI::base().'modules/mod_squadmanagement_wars/tmpl/style.css';
$document->addStyleSheet($cssHTML);	

if ($state == 1)
{
	require(JModuleHelper::getLayoutPath('mod_squadmanagement_wars'));
}
else
{
	require JModuleHelper::getLayoutPath('mod_squadmanagement_wars', 'scheduled');
}

?>