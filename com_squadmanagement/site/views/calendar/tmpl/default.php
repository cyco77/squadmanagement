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

require_once JPATH_COMPONENT.'/helpers/calendar.php';

JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal'); 

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/calendar.css');		

$html = array();

if ($this->params->get('show_page_heading', 1)) : 
	$html[] = '<h1>';
	if ($this->escape($this->params->get('page_heading'))) :
		$html[] = $this->escape($this->params->get('page_heading')); 
	else : 
		$html[] = $this->escape($this->params->get('page_title')); 
	endif;
	$html[] = '</h1>';
endif; 


$html[] = '<div id="warlisttemplate_wars">';

$html[] = CalendarHelper::RenderMonth($this->year,$this->month,$this->items,$this->appointments,$this->wartemplateName);

$categories =  $this->params->get('appointmentcategories','');

$list = explode("\n", $categories);

$html[] = CalendarHelper::renderLegend($list);

$html[] = '</div>';

echo implode("\n", $html); 

?>