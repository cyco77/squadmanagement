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

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';

JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal'); 

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/appointments.css');	

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

$html = array();

$user = JFactory::getUser();
$userid = $user->get('id');
if ($userid != 0 && ($this->canAddAppointments))
{
	$doc = JFactory::getDocument();
	$cssHTML = JURI::base().'components/com_squadmanagement/style/admintoolbar.css';
	$doc->addStyleSheet($cssHTML);
	
	$link = JRoute::_( 'index.php?option=com_squadmanagement&view=editappointment&id=-1' );
	
	$html[] = '<div id="squadmanagement_admin_toolbar">';
	
	$html[] = '<div class="squadmanagement_admin_toolbar_editprofile">';
	$html[] = '<a href="'.$link.'" >';
	$html[] = '<div class="squadmanagement_admin_toolbar_item">';
	$html[] = '<div class="squadmanagement_admin_toolbar_image">';		
	$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/toolbox.png" />';
	$html[] = '</div>';
	$html[] = '<div class="squadmanagement_admin_toolbar_caption">';	
	$html[] = JText::_('COM_SQUADMANAGEMENT_FIELD_ADDAPPOINTMENT');
	$html[] = '</div>';
	$html[] = '</div>';
	$html[] = '</a>';
	$html[] = '</div>';
	
	$html[] = '</div>';
}

echo implode("\n", $html); 

$templateName = $this->templateName;
if ($templateName == '')
{
	$templateName = $this->params->get( 'appointmentstemplate' , 'Default');	
}

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'appointments'.DIRECTORY_SEPARATOR.$templateName.DIRECTORY_SEPARATOR.'template.php');

$templateClass = strtolower($templateName).'appointmentstemplate';

$template = new $templateClass;
$template->init($this->items,$this->pagination,$this->state);
$template->renderTemplate();

?>