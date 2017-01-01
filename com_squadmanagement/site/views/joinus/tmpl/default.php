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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
JHtml::_('jquery.framework');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/form.css');
$document->addScript( JURI::root().'/components/com_squadmanagement/script/joinus.js' );

$html = array();

$html[] = '<div style="clear:both"/>';

if ($this->params->get('show_page_heading', 1)) : 
	$html[] = '<h1>';
	if ($this->escape($this->params->get('page_heading'))) :
		$html[] = $this->escape($this->params->get('page_heading')); 
	else : 
		$html[] = $this->escape($this->params->get('page_title')); 
	endif;
	$html[] = '</h1>';
endif; 

$html[] = '<form class="form-validate" action="'. JRoute::_('index.php?option=com_squadmanagement&view=joinus') . '" method="post" name="joinusForm" id="joinus-form">';
$html[] = '	<div id="squadmanagement_challenge">';
$html[] = '			<div class="adminform">';
$html[] = '				<div>'. $this->form->getLabel('displayname');
$html[] =				$this->form->getInput('displayname') . '</div>';
$html[] = '				<div>'. $this->form->getLabel('squadid');
$html[] =				$this->form->getInput('squadid') . '</div>';
$html[] = '				<div>';
$html[] = '			<div class="clr"></div>';
$html[] =			$this->form->getLabel('joinusdescription'); 
$html[] = '			<div class="clr"></div>';
$html[] =			$this->form->getInput('joinusdescription');
$html[] = '				</div>';
$html[] = '			</div>';
$html[] = '	</div>';
$html[] = '	<button type="submit" class="button">' . JText::_('COM_SQUADMANAGEMENT_FIELD_JOINUS_SAVE') . '</button>';
$html[] = '	<div>';
$html[] = '		<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = '		<input type="hidden" name="task" value="joinus.submit" />';
$html[] = JHtml::_('form.token');
$html[] = '	</div>';
$html[] = '</form>';

$html[] = '</div>';

echo implode("\n", $html); 