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

JHtml::_('jquery.framework');

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

$user = JFactory::getUser();
$userid = $user->get('id');
if ($userid != 0 && ($userid == $this->canAddWars))
{
	$doc = JFactory::getDocument();
	$cssHTML = JURI::base().'components/com_squadmanagement/style/admintoolbar.css';
	$doc->addStyleSheet($cssHTML);
	
	$link = JRoute::_( 'index.php?option=com_squadmanagement&view=editwar&id=-1' );
	
	$html[] = '<div id="squadmanagement_admin_toolbar">';
	
	$html[] = '<div class="squadmanagement_admin_toolbar_editprofile">';
	$html[] = '<a href="'.$link.'" >';
	$html[] = '<div class="squadmanagement_admin_toolbar_item">';
	$html[] = '<div class="squadmanagement_admin_toolbar_image">';		
	$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/toolbox.png" />';
	$html[] = '</div>';
	$html[] = '<div class="squadmanagement_admin_toolbar_caption">';	
	$html[] = JText::_('COM_SQUADMANAGEMENT_FIELD_ADDWAR');
	$html[] = '</div>';
	$html[] = '</div>';
	$html[] = '</a>';
	$html[] = '</div>';
	
	$html[] = '</div>';
}

echo implode("\n", $html);

$warlisttemplateName = $this->warlisttemplateName;
if ($warlisttemplateName == '')
{
	$warlisttemplateName = $this->params->get( 'warlisttemplate' , 'Default');	
}

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'warlist'.DIRECTORY_SEPARATOR.$warlisttemplateName.DIRECTORY_SEPARATOR.'template.php');

$templateClass = strtolower($warlisttemplateName).'warlisttemplate';

$template = new $templateClass;
$template->init($this->items,$this->pagination,$this->summary,$this->state,$this->wartemplateName);
$template->renderTemplate();

?>