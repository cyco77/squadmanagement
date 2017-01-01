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

JHTML::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/form.css');
$document->addScript( JURI::root().'/components/com_squadmanagement/script/tooltip.js' );
$document->addScript( JURI::root().'/components/com_squadmanagement/script/editappointment.js' );
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admintoolbar.css');

$html = array();

$html[] = '	<div style="clear:both;">';

$html[] = '<form action="'.JRoute::_('index.php?option=com_squadmanagement&tmpl=component&view=editappointment&id='.(int) $this->id).'" method="post" name="adminForm" id="adminForm">';

$html[] = '<div id="squadmanagement_admin_toolbar">';
$html[] = '	<div class="squadmanagement_admin_toolbar_editprofile">';
$html[] = '		<div class="squadmanagement_admin_toolbar_item">';
$html[] = '			<div class="squadmanagement_admin_toolbar_image">';		
$html[] = '				<input id="savewarbutton" type="submit" value="'.JText::_('COM_SQUADMANAGEMENT_FIELD_SAVEAPPOINTMENT').'" alt="Submit" >';
$html[] = '			</div>';
$html[] = '		</div>';
$html[] = '	</div>';
$html[] = '</div>';

$html[] = '		<fieldset class="adminform">';
$html[] = '			<div class="adminform">';
$html[] = '				<div style="clear:both">';
$html[] = '					<div>'.$this->form->getLabel('id').'</div>';
$html[] = '					<div>'.$this->form->getInput('id').'</div>';
$html[] = '				</div>';
$html[] = '				<div  style="clear:both">';
$html[] = '					<div class="control-label">'.$this->form->getLabel('subject').'</div>';
$html[] = '					<div class="controls">'.$this->form->getInput('subject').'</div>';
$html[] = '				</div>';
$html[] = '				<div  style="clear:both">';
$html[] = '					<div class="control-label">'.$this->form->getLabel('squadid').'</div>';
$html[] = '					<div class="controls">'.$this->form->getInput('squadid').'</div>';
$html[] = '				</div>';
$html[] = '				<div  style="clear:both">';
$html[] = '					<div class="control-label">'.$this->form->getLabel('type').'</div>';
$html[] = '					<div class="controls">'.$this->form->getInput('type').'</div>';
$html[] = '				</div>';
$html[] = '				<div  style="clear:both">';
$html[] = '					<div class="control-label">'.$this->form->getLabel('startdatetime').'</div>';
$html[] = '					<div class="controls">'.$this->form->getInput('startdatetime').'</div>';
$html[] = '				</div>';
$html[] = '				<div  style="clear:both">';
$html[] = '					<div class="control-label">'.$this->form->getLabel('enddatetime').'</div>';
$html[] = '					<div class="controls">'.$this->form->getInput('enddatetime').'</div>';
$html[] = '				</div>';
$html[] = '				<div  style="clear:both">';
$html[] = '					<div class="control-label">'.$this->form->getLabel('duration').'</div>';
$html[] = '					<div class="controls">'.$this->form->getInput('duration').'</div>';
$html[] = '				</div>';
$html[] = '					<div style="clear:both;">';
$html[] = '						<div>' . $this->form->getLabel('body');
$html[] =						$this->form->getInput('body').'</div>';
$html[] = '					</div>';

$html[] = '			</div>';
$html[] = '		</fieldset>';
$html[] = '	</div>';

$html[] = '		<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = '		<input type="hidden" name="task" value="editappointment.submit" />';
$html[] = JHtml::_('form.token');
$html[] = '	</form>';

echo implode("\n", $html); 

?>