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
JHtml::_('jquery.framework');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/form.css');
$document->addScript( JURI::root().'/components/com_squadmanagement/script/tooltip.js' );
$document->addScript( JURI::root().'/components/com_squadmanagement/script/editwar.js' );
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admintoolbar.css');

$html = array();

$html[] = '	<div style="clear:both;">';

$html[] = '<form action="'.JRoute::_('index.php?option=com_squadmanagement&tmpl=component&view=editwar&id='.(int) $this->id).'" method="post" name="adminForm" id="adminForm">';

$html[] = '<div id="squadmanagement_admin_toolbar">';
$html[] = '	<div class="squadmanagement_admin_toolbar_editprofile">';
$html[] = '		<div class="squadmanagement_admin_toolbar_item">';
$html[] = '			<div class="squadmanagement_admin_toolbar_image">';		
$html[] = '				<input id="savewarbutton" type="submit" value="'.JText::_('COM_SQUADMANAGEMENT_FIELD_SAVEWAR').'" alt="Submit" >';
$html[] = '			</div>';
$html[] = '		</div>';
$html[] = '	</div>';
$html[] = '</div>';

$html[] = JHtml::_('tabs.start');
$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_WAR_DETAILS'),JText::_('COM_SQUADMANAGEMENT_WAR_DETAILS'));		

$html[] = '		<fieldset class="adminform">';
$html[] = '				<div class="adminform">';
$html[] = '					<div style="clear:both">';
$html[] = '						<div>'.$this->form->getLabel('id').'</div>';
$html[] = '						<div>'.$this->form->getInput('id').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('wardatetime').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('wardatetime').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('state').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('state').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('squadid').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('squadid').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('opponentid').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('opponentid').'</div>';
$html[] = '						<div style="vertical-alignment: middle;cursor: pointer;" onclick="showopponentdiv();"><img src="'.JURI::root().'components/com_squadmanagement/images/add.png" alt="Add Opponent" title="Add Opponent" /></div>';
$html[] = '					</div>';

$html[] = '					<div  style="clear:both">';
$html[] = '						<input type="hidden" name="jform[opponentname]" id="jform_opponentname" value="">';
$html[] = '					</div>';

$html[] = '					<div id="addopponentdivprogressing" style="display:none; clear: both;">';
$html[] = '						Please wait...';
$html[] = '					</div>';
$html[] = '					<div id="addopponentdiv" style="display:none; clear: both;">';
$html[] = '					</div>';

$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('leagueid').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('leagueid').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('matchlink').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('matchlink').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('lineup').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('lineup').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('lineupopponent').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('lineupopponent').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('score').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('score').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('scoreopponent').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('scoreopponent').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('resultscreenshot').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('resultscreenshot').'</div>';
$html[] = '					</div>';
$html[] = '					<div  style="clear:both">';
$html[] = '						<div class="control-label">'.$this->form->getLabel('challengedescription').'</div>';
$html[] = '						<div class="controls">'.$this->form->getInput('challengedescription').'</div>';
$html[] = '					</div>';
$html[] = '				</div>';

$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_DESCRIPTION'),JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_DESCRIPTION'));	

$html[] = '				<div class="clr"></div>';
$html[] = $this->form->getLabel('description');
$html[] = '				<div class="clr"></div>';
$html[] = $this->form->getInput('description');
$html[] = '				<div>';
$html[] = '					<input type="hidden" name="task" value="editwar.submit" />';
$html[] = '					<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = JHtml::_('form.token');
$html[] = '				</div>';
$html[] = '		</fieldset>	';

$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_WARMEMBERS_DETAILS'),JText::_('COM_SQUADMANAGEMENT_WARMEMBERS_DETAILS'));	

$html[] = '		<fieldset class="adminform">';
$html[] = '			<table class="table table-striped">';
$html[] = '				<thead>';
$html[] = '					<tr>';
$html[] = '						<th>';
$html[] = '						</th>';
$html[] = '						<th>';
$html[] = JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_NAME' );
$html[] = '						</th>';
$html[] = '						<th>';
$html[] = JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS' ); 
$html[] = '						</th>';
$html[] = '						<th>';
$html[] = JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_POSITION' );
$html[] = '						</th>';
$html[] = '						<th>';
$html[] = '						</th>';
$html[] = '					</tr>';
$html[] = '				</thead>';				
$html[] = '				<tbody>';
foreach ($this->members as $member)
{
	$html[] = '					<tr>';
	$html[] = ' 		<td align="center" valign="middle">';
	
	$image = IntegrationHelper::getFullAvatarImagePath($member->avatar);
	$width = ImageHelper::getImageWidth($image,50);

	$html[] = ' 			<img src="'.$image.'" alt="' . $member->membername . '" style="height:50px;width:'.$width.'px"/>'; 
	$html[] = ' 		</td>';
	$html[] = '						<td>';
	$html[] = $member->membername;				
	$html[] = '						</td>';
	$html[] = '						<td>';
	$html[] = '							<input name="jform[warmemberid_id_'.$member->userid.']" id="jform_warmemberid_id_'.$member->userid.'" type="hidden" value="'.$member->id.'"/>';				
	$html[] = '							<select id="jform_warmemberposition_id_'.$member->userid.'" name="jform[warmemberstate_id_'.$member->userid.']" size="1">';
	$html[] = '								<option value="0" '. ($member->state == 0 ? 'selected="selected"' : '') .'>'.JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_UNKNOWN' ).'</option>';
	$html[] = '								<option value="1" '. ($member->state == 1 ? 'selected="selected"' : '') .'>'.JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_YES' ).'</option>';
	$html[] = '								<option value="2" '. ($member->state == 2 ? 'selected="selected"' : '') .'>'.JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_MAYBE' ).'</option>';
	$html[] = '								<option value="3" '. ($member->state == 3 ? 'selected="selected"' : '') .'>'.JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_NO' ).'</option>';
	$html[] = '							</select>';
	$html[] = '						</td>';
	$html[] = '						<td>';
	$html[] = '							<input name="jform[warmemberposition_id_'.$member->userid.']" id="jform_warmemberposition_id_'.$member->userid.'" type="text" value="'.$member->position.'"/>';				
	$html[] = '						</td>';
	$html[] = '						<td>';
	if (isset($member->comment) && $member->comment != '')
	{
		$html[] = '			<img src="'.JURI::root().'components/com_squadmanagement/images/note.png" style="width:24px; heigth: 24px;" alt="'.$member->comment.'" title="'.$member->comment.'"/>';	
	}
	$html[] = '						</td>';
	$html[] = '					</tr>';
}			
$html[] = '				</tbody>';
$html[] = '			</table>';	
$html[] = '		</fieldset>';
$html[] = '	</form>';

$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_WARROUNDS_DETAILS'),JText::_('COM_SQUADMANAGEMENT_WARROUNDS_DETAILS'));	

$html[] = '	<fieldset class="adminform">';
$html[] = '		<div id="squadmanagementsavefirst">'.JText::_( 'COM_SQUADMANAGEMENT_EDITWAR_SAVEFIRST' ).'</div>';
$html[] = '		<div id="roundsDiv"></div>';
$html[] = '		<div id="squadmanagementprogressing" style="display:hidden">Please Wait</div>';
$html[] = '	</fieldset>';

$html[] = '	<input id="squadmanagementaddround" type="button" class="button" name="Add" value="Add" onclick="addRound()">';

$html[] = '	<div style="clear:both;">';
$html[] = '		<div id="addroundDiv"></div>';
$html[] = '	</div>';

$html[] = JHtml::_('tabs.end');

$html[] = '	</div>';

echo implode("\n", $html); 

?>