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

JHTML::_('behavior.modal'); 
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
if ($userid != 0 && ($userid == $this->item->squadleader || $userid == $this->item->waradmin || ($this->isUserInSquad && $this->item->state != 1)))
{
	$doc = JFactory::getDocument();
	$cssHTML = JURI::base().'components/com_squadmanagement/style/admintoolbar.css';
	$doc->addStyleSheet($cssHTML);
	
	$html[] = '<div id="squadmanagement_admin_toolbar">';
	
	if ($userid == $this->item->squadleader || $userid == $this->item->waradmin)
	{
		$link = JRoute::_( 'index.php?option=com_squadmanagement&view=editwar&id='. $this->item->id );		
	
		$html[] = '<div class="squadmanagement_admin_toolbar_editprofile">';
		$html[] = '<a href="'.$link.'" >';
		$html[] = '<div class="squadmanagement_admin_toolbar_item">';
		$html[] = '<div class="squadmanagement_admin_toolbar_image">';		
		$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/toolbox.png" />';
		$html[] = '</div>';
		$html[] = '<div class="squadmanagement_admin_toolbar_caption">';	
		$html[] = JText::_('COM_SQUADMANAGEMENT_FIELD_EDITWAR');
		$html[] = '</div>';
		$html[] = '</div>';
		$html[] = '</a>';
		$html[] = '</div>';
	}
	
	if ($this->isUserInSquad && $this->item->state != 1)
	{
		$link = JRoute::_( 'index.php?option=com_squadmanagement&tmpl=component&view=updatewarmemberstate&warid='. $this->item->id );
		
		$html[] = '<div class="squadmanagement_admin_toolbar_editprofile">';
		$html[] = '<a href="'.$link.'" class="modal" rel="{handler: \'iframe\', size: {x: 300, y: 350}}"  >';
		$html[] = '<div class="squadmanagement_admin_toolbar_item">';
		$html[] = '<div class="squadmanagement_admin_toolbar_image">';		
		$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/warmemberstate.png" />';
		$html[] = '</div>';
		$html[] = '<div class="squadmanagement_admin_toolbar_caption">';	
		$html[] = JText::_('COM_SQUADMANAGEMENT_FIELD_EDITWARMEMBERSTATE');
		$html[] = '</div>';
		$html[] = '</div>';
		$html[] = '</a>';
		$html[] = '</div>';
	}
	
	$html[] = '</div>';
}

echo implode("\n", $html); 

$templateName = $this->templateName;
if ($templateName == '')
{
	$templateName = $this->params->get( 'wartemplate' , 'Default');	
}

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'war'.DIRECTORY_SEPARATOR.$templateName.DIRECTORY_SEPARATOR.'template.php');

$templateClass = strtolower($templateName).'wartemplate';

$template = new $templateClass;
$template->init($this->item,$this->params);
$template->renderTemplate();

?>