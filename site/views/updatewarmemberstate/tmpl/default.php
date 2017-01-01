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

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/form.css');

$html = array();

$html[] = '<div style="clear:both"/>';

$html[] = '<form class="form-validate" action="'. 'index.php?option=com_squadmanagement&view=updatewarmemberstate&warid='.$this->warid . '" method="post" name="updatewarmemberstateForm" id="updatewarmemberstate-form">';
$html[] = '	<div id="squadmanagement_challenge">';
$html[] = '			<div class="adminform">';
$html[] = '				<div>'. $this->form->getLabel('id');
$html[] =				$this->form->getInput('id') . '</div>';
$html[] = '				<div>'. $this->form->getLabel('state');
$html[] =				$this->form->getInput('state') . '</div>';
$html[] = '				<div>'. $this->form->getLabel('comment');
$html[] =				$this->form->getInput('comment') . '</div>';
$html[] = '				<div>';
$html[] = '			</div>';
$html[] = '	</div>';
$html[] = '	<button type="submit" class="button">' . JText::_('COM_SQUADMANAGEMENT_FIELD_UPDATEWARMEMBERSTATE_SAVE') . '</button>';
$html[] = '	<div>';
$html[] = '		<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = '		<input type="hidden" name="task" value="updatewarmemberstate.submit" />';
$html[] = JHtml::_('form.token');
$html[] = '	</div>';
$html[] = '</form>';

$html[] = '</div>';

echo implode("\n", $html); 