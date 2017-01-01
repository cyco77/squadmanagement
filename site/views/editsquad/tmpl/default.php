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
$document->addScript( JURI::root().'/components/com_squadmanagement/script/editsquad.js' );
$document->addScript( JURI::root().'/components/com_squadmanagement/script/tooltip.js' );
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admintoolbar.css');

$html = array();

$html[] = '<div style="clear:both;">';

$html[] = '<form action="'.JRoute::_('index.php?option=com_squadmanagement&view=editsquad&id='.$this->item->id).'" method="post" name="adminForm" id="squad-form" class="adminform">';

$html[] = '<div id="squadmanagement_admin_toolbar">';
$html[] = '	<div class="squadmanagement_admin_toolbar_editprofile">';
$html[] = '		<div class="squadmanagement_admin_toolbar_item">';
$html[] = '			<div class="squadmanagement_admin_toolbar_image">';	
$html[] = '				<input id="savewarbutton" type="submit" value="'.JText::_('COM_SQUADMANAGEMENT_FIELD_EDITSQUAD_SAVE').'" alt="Submit" >';	
$html[] = '			</div>';
$html[] = '		</div>';
$html[] = '	</div>';
$html[] = '</div>';

$html[] = JHtml::_('tabs.start');
$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_COMMON'),JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_COMMON'));						

$html[] = '		<div class="adminform">';	
$html[] = '			<div style="clear:both">'. $this->form->getLabel('id');
$html[] =			$this->form->getInput('id').'</div>';
$html[] = '			<div style="clear:both">'. $this->form->getLabel('shortname');
$html[] =			$this->form->getInput('shortname').'</div>';
$html[] = '			<div style="clear:both">'. $this->form->getLabel('name');
$html[] =			$this->form->getInput('name').'</div>';
$html[] = '			<div style="clear:both">'. $this->form->getLabel('waradmin');
$html[] =			$this->form->getInput('waradmin').'</div>';
$html[] = '			<div style="clear:both">'. $this->form->getLabel('icon');
$html[] =			$this->form->getInput('icon').'</div>';
$html[] = '			<div style="clear:both">'. $this->form->getLabel('image');
$html[] =			$this->form->getInput('image').'</div>';
$html[] = '		</div>';

$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_DESCRIPTION'),JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_DESCRIPTION'));						

$html[] = '		<div class="adminform">';
$html[] = '			<div style="clear:both">';
$html[] =			$this->form->getInput('description').'</div>';
$html[] = '		</div>';

$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_MEMBERS'),JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_MEMBERS'));						

$html[] = '<div id="memberlist">';
$html[] = '</div>';

$html[] = '<div id="addmember">';

$html[] = '<table>';
$html[] = '	<tr>';
$html[] = '		<td>';
$html[] = '			UserID';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			Username';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			Role';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '		</td>';
$html[] = '	</tr>';
$html[] = '	<tr>';
$html[] = '		<td>';
$html[] = '			<input id="userid" style="width: 40px;" />';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			<input autocomplete="off" id="usernamefilter" type="text" onkeyup="queryUsers('.$this->item->id.')"/>';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			<input id="role" type="text"/>';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			<a href="#" onClick="addSquadMember('.$this->item->id.'); return false;">';
$html[] = '				<img  src="'.JURI::base().'components/com_squadmanagement/images/user-add.png" alt="Add"/>';
$html[] = '			</a>';
$html[] = '		</td>';
$html[] = '	</tr>';
$html[] = '</table>';

$html[] = '<div id="usernamesugestions" style="display:none;" >';
$html[] = '</div>';

$html[] = '<div id="errormessage" style="display:none;" >';
$html[] = '</div>';

$html[] = '</div>';

$html[] = JHtml::_('tabs.end');

$html[] = '	<div>';
$html[] = '		<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = '		<input type="hidden" name="task" value="editsquad.submit" />';
$html[] = JHtml::_('form.token'); 
$html[] = '	</div>';
$html[] = '</form>';

$html[] = '	</div>';

echo implode("\n", $html); 

?>