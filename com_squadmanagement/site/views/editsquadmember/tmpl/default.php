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
$document->addScript( JURI::root().'/components/com_squadmanagement/script/editsquadmember.js' );
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admintoolbar.css');
$document->addScript( JURI::root().'/components/com_squadmanagement/script/tooltip.js' );

$html = array();

if (JRequest::getCmd('task') == 'success')
{
	$html[] = '			<div id="squadmanagement_message" class="squadmanagement_save_success">';	
	$html[] = JText::_('COM_SQUADMANAGEMENT_FIELD_EDITSQUADMEMBER_SAVE_SUCCESS');	
	$html[] = '			</div>';	
}
elseif (JRequest::getCmd('task') == 'failed')
{
	$html[] = '			<div id="squadmanagement_message" class="squadmanagement_save_fail">';	
	$html[] = JText::_('COM_SQUADMANAGEMENT_FIELD_EDITSQUADMEMBER_SAVE_FAIL');	
	$html[] = '			</div>';	
}

$html[] = '<div style="clear:both;" >';

$html[] = '<form action="'. JRoute::_('index.php?option=com_squadmanagement&view=editsquadmember&id='.$this->item->id).'" method="post" name="adminForm" id="squadmember-form">';

$html[] = '<div id="squadmanagement_admin_toolbar">';
$html[] = '	<div class="squadmanagement_admin_toolbar_editprofile">';
$html[] = '		<div class="squadmanagement_admin_toolbar_item">';
$html[] = '			<div class="squadmanagement_admin_toolbar_image">';	
$html[] = '				<input id="savebutton" type="submit" value="'.JText::_('COM_SQUADMANAGEMENT_FIELD_EDITSQUADMEMBER_SAVE').'" alt="Submit" >';	
$html[] = '			</div>';
$html[] = '		</div>';
$html[] = '	</div>';
$html[] = '</div>';

$html[] = JHtml::_('tabs.start');
$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUADMEMBER_COMMON'),JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUADMEMBER_COMMON'));						

$html[] = '<div class="adminform">';
$html[] = '	<div>'. $this->form->getLabel('userid');
$html[] =	$this->form->getInput('userid').'</div>';
$html[] = '	<div style="clear:both">'. $this->form->getLabel('displayname');
$html[] =	$this->form->getInput('displayname').'</div>';
$html[] = '	<div style="clear:both">'. $this->form->getLabel('steamid');
$html[] =	$this->form->getInput('steamid').'</div>';
$html[] = '	<div style="clear:both">'. $this->form->getLabel('imageurl');
$html[] =	$this->form->getInput('imageurl').'</div>';
$html[] = '</div>';

$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUADMEMBER_DESCRIPTION'),JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUADMEMBER_DESCRIPTION'));						

$html[] = '<div class="adminform">';
$html[] = '	<div style="clear:both" />';
$html[] =	$this->form->getInput('description');
$html[] = '</div>';

$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUADMEMBER_ADDITIONALINFOS'),JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUADMEMBER_ADDITIONALINFOS'));						

$html[] = '<div class="adminform">';		

$lastTab = '<<unknown>>';	
$fields = get_object_vars($this->item);		

foreach ($this->additionalFields as $additionalfield)
{
	if ($lastTab != $additionalfield->tabname)
	{	
		$html[] = '</div>';
		$tabname = $additionalfield->tabname != null ? $additionalfield->tabname : JText::_('COM_SQUADMANAGEMENT_FIELD_EDITSQUADMEMBER_COMMON');	
		$html[] = '<div class="adminform">';
		$html[] = '<div><b>'.$tabname.'</b></div>';	
		$lastTab = $additionalfield->tabname;
	}
	
	foreach ($fields as $name=>$field)
	{
		$needle = 'field_';
		$length = strlen($needle);
		
		if (substr($name, 0, $length) === $needle)
		{							
			if ($additionalfield->fieldname == $name)
			{
				$html[] = '	<div>';
				$html[] = '		<label id="jform_'.$name.'-lbl" for="jform_'.$name.'" class="required" title="">'.$additionalfield->name.'</label>';
				$html[] = '		<input type="text" name="jform['.$name.']" id="jform_'.$name.'" value="'.$this->item->$name.'" size="40">';
				$html[] = '	</div>';
			}				
		}						
	}
}		
$html[] = '</div>';			

$html[] = JHtml::_('tabs.end'); 	

$html[] = '	<div>';
$html[] = '		<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = '		<input type="hidden" name="task" value="editsquadmember.submit" />';
$html[] = JHtml::_('form.token'); 
$html[] = '	</div>';
$html[] = '</form>';

$html[] = '</div>';

echo implode("\n", $html); 

?>