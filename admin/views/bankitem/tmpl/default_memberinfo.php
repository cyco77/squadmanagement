<?php

$html = array();

$html[] = '<div class="control-group">';
$html[] = '	<div class="control-label">';
$html[] = '		<label id="jform_dues-lbl" for="jform_dues" class="required" title="">'.JText::_( 'COM_SQUADMANAGEMENT_SQUADMEMBER_DUES' ).'</label>';
$html[] = '	</div>';
$html[] = '	<div class="controls">';
$html[] = '		<input type="text" name="jform[dues]" id="jform_dues" value="'.$this->data->dues.'" size="40" onchange="updatePayedTo()">';
$html[] = '	</div>';
$html[] = '</div>';

$html[] = '<div class="control-group">';
$html[] = '	<div class="control-label">';
$html[] = '		<label id="jform_payedto-lbl" for="jform_payedto" class="required" title="">'.JText::_( 'COM_SQUADMANAGEMENT_SQUADMEMBER_PAYEDTO' ).'</label>';
$html[] = '	</div>';
$html[] = '	<div class="controls">';
$html[] = '		<input type="text" name="jform[payedto]" id="jform_payedto" value="'.$this->data->payedto.'" size="40" ></div>';
$html[] = '	</div>';
$html[] = '</div>';

$html[] = '<div><input type="hidden" name="jform[payedto_hidden]" id="jform_payedto_hidden" value="'.$this->data->payedto.'" ></div>';

echo implode("\n", $html); 