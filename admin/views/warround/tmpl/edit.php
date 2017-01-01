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
$html[] = '		<div class="adminformlist">';
foreach($this->form->getFieldset() as $field)
{
	$html[] = '			<div>' . $field->label . $field->input .'</div>';
}
$html[] = '			<div style="clear:both;"><input type="button" class="button" name="Save" value="Save" onclick="saveRound()"></div>';
$html[] = '		</div>';
$html[] = '	</fieldset>';
$html[] = '	</form>';

echo implode("\n", $html);
