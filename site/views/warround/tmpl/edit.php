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

$html[] = '	<form name="addroundform">';
$html[] = '	<fieldset class="adminform">';
$html[] = '		<legend>'. JText::_( 'COM_SQUADMANAGEMENT_WARROUNDS_ADD' ) . '</legend>';
$html[] = '		<div class="adminform">';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('id').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('id').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('map').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('map').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('mapimage').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('mapimage').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('roundscore').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('roundscore').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('roundscoreopponent').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('roundscoreopponent').'</div>';
$html[] = '			</div>';
$html[] = '			<div  style="clear:both">';
$html[] = '				<div class="control-label">'.$this->form->getLabel('screenshot').'</div>';
$html[] = '				<div class="controls">'.$this->form->getInput('screenshot').'</div>';
$html[] = '			</div>';

$html[] = '			<div style="clear:both;"><input type="button" class="button" name="Save" value="Save" onclick="saveRound()"></div>';
$html[] = '		</div>';
$html[] = '	</fieldset>';
$html[] = '	</form>';

echo json_encode(implode("\n", $html));
