<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.helper' );

$squadid = $params->get( 'squadid', '0' );
$maxitemcount = $params->get( 'maxitemcount', 5);

$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select('a.id, a.type, a.startdatetime, a.enddatetime, a.duration, a.subject, a.published, a.ordering, s.name as squadname, s.icon as squadlogo');

$query->from('#__squad_appointment a INNER JOIN #__squad s ON s.id = a.squadid');
$query->where('a.published = 1 and a.startdatetime > UTC_TIMESTAMP()');	

if (is_numeric($squadid) && $squadid > 0)
{
	$query->where('a.squadid = '.(int) $squadid);	
}

$query->order('a.startdatetime');

$db->setQuery($query,0,$maxitemcount);
$list = $db->loadObjectList();

$document = JFactory::getDocument();

$cssHTML = JURI::base().'modules/mod_squadmanagement_appointments/tmpl/style.css';
$document->addStyleSheet($cssHTML);	

require(JModuleHelper::getLayoutPath('mod_squadmanagement_appointments'));


?>