<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squadmanagement!
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

$html[] = '	<form name="addopponentform">';
$html[] = '	<fieldset class="adminform">';
$html[] = '		<legend>'. JText::_( 'COM_SQUADMANAGEMENT_OPPONENT_ADD' ) . '</legend>';
$html[] = '		<div class="adminform">';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('name').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('name').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('logo').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('logo').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('contact').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('contact').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('contactemail').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('contactemail').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('url').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('url').'</div>';
$html[] = '			</div>';

$html[] = '			<div style="clear:both;"><input type="button" class="button" name="Save" value="Save" onclick="saveOpponent()"></div>';
$html[] = '		</div>';
$html[] = '	</fieldset>';
$html[] = '	</form>';

echo json_encode(implode("\n", $html));
