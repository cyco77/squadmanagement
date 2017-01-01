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
$document->addScript( JURI::root().'/components/com_squadmanagement/script/challenge.js' );
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/form.css');

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

// User
$user = JFactory::getUser();
$user_id = $user->get('id');

jimport( 'joomla.access.access' );
$groups = JAccess::getGroupsByUser($user_id, false);

$html[] = '<form class="form-validate" action="'. JRoute::_('index.php?option=com_squadmanagement&view=challenge') . '" method="post" name="challengeForm" id="challenge-form">';
$html[] = '	<div id="squadmanagement_challenge">';
$html[] = '		<div class="adminform">';
$html[] = '			<div>'. $this->form->getLabel('wardatetime');
$html[] =				$this->form->getInput('wardatetime') . '</div>';
$html[] = '			<div>'. $this->form->getLabel('opponent');
$html[] =				$this->form->getInput('opponent') . '</div>';
$html[] = '			<div style="display:none;" id="opponentsugestions"></div>';
$html[] = '			<div id="opponenturl">'. $this->form->getLabel('opponenturl');
$html[] =				$this->form->getInput('opponenturl') . '</div>';

$user = JFactory::getUser();
if ($user->guest)
{
	$html[] = '			<div id="contact">'. $this->form->getLabel('contact');
	$html[] =				$this->form->getInput('contact') . '</div>';
	$html[] = '			<div id="contactemail">'. $this->form->getLabel('contactemail');
	$html[] =				$this->form->getInput('contactemail') . '</div>';
}

$html[] = '			<div>'. $this->form->getLabel('squadid');
$html[] =				$this->form->getInput('squadid') . '</div>';
$html[] = '			<div>'. $this->form->getLabel('leagueid');
$html[] =				$this->form->getInput('leagueid') . '</div>';
$html[] = '			<div>'. $this->form->getLabel('matchlink');
$html[] =				$this->form->getInput('matchlink') . '</div>';
$html[] = '			<div>'. $this->form->getLabel('lineupopponent');
$html[] =				$this->form->getInput('lineupopponent') . '</div>';
$html[] = '			<div>';
$html[] = '				<div class="clr"></div>';
$html[] =					$this->form->getLabel('description'); 
$html[] = '				<div class="clr"></div>';
$html[] =					$this->form->getInput('description');
$html[] = '			</div>';

// reCaptcha
$user = JFactory::getUser();

//if ($user->guest)
{
	$html[] = '		<div class="clr"></div>';
	$html[] = '		<div class="adminform">';
	$html[] = '			<div>'. $this->form->getInput('captcha') . '</div>';
	$html[] = '		</div>';	
}

$html[] = '		</div>';
$html[] = '	</div>';
$html[] = '	<button type="submit" class="button">' . JText::_('COM_SQUADMANAGEMENT_FIELD_CHALLENGE_SAVE') . '</button>';
$html[] = '	<div>';
$html[] = '		<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = '		<input type="hidden" name="task" value="challenge.submit" />';
$html[] = JHtml::_('form.token');
$html[] = '	</div>';
$html[] = '</form>';

$html[] = '</div>';

echo implode("\n", $html); 

?>