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

echo implode("\n", $html);

$templateName = $this->templateName;
if ($templateName == '')
{
	$templateName = $this->params->get( 'squadcategorylisttemplate' , 'Blocks');	
}

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'squadcategorylist'.DIRECTORY_SEPARATOR.$templateName.DIRECTORY_SEPARATOR.'template.php');

$templateClass = strtolower($templateName).'squadcategorylisttemplate';

$template = new $templateClass;
$template->init($this->categories,$this->additionalfields);
$template->renderTemplate();

?>