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

JHtml::_('behavior.tooltip');
JHtml::_('jquery.framework');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');
$document->addScript( JURI::base().'components/com_squadmanagement/script/war.js' );

?>

<form action="<?php echo JRoute::_('index.php?option=com_squadmanagement&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
	<div class="span6 form-horizontal">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_WAR_DETAILS' ); ?></legend>
				<div class="adminformlist">
					<?php echo $this->form->getInput('id'); ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('wardatetime'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('wardatetime'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('published'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('published'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('squadid'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('squadid'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('opponentid'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('opponentid'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('leagueid'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('leagueid'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('matchlink'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('matchlink'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('lineup'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('lineup'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('lineupopponent'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('lineupopponent'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('score'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('score'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('scoreopponent'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('scoreopponent'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('resultscreenshot'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('resultscreenshot'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('challengedescription'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('challengedescription'); ?></div>
					</div>
				</div>
								
				<div class="clr"></div>
				<?php echo $this->form->getLabel('description'); ?>
				<div class="clr"></div>
				<?php echo $this->form->getInput('description'); ?>
								
				<div>
					<input type="hidden" name="task" value="war.edit" />
					<?php echo JHtml::_('form.token'); ?>
				</div>
		</fieldset>	
	</div>
	<div class="span6">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_DETAILS' ); ?></legend>
			
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							<?php echo JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_NAME' ); ?>
						</th>
						<th>
							<?php echo JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS' ); ?>
						</th>
						<th>
							<?php echo JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_POSITION' ); ?>
						</th>	
						<th>		
						</th>	
					</tr>
				</thead>				
				<tbody>
						<?php
						if (isset($this->members))
						{
							foreach ($this->members as $member)
							{
								echo '<tr>';
								echo '	<td>';
								echo $member->username;				
								echo '	</td>';
								echo '	<td>';
								echo '	<input name="jform[warmemberid_id_'.$member->userid.']" id="jform_warmemberid_id_'.$member->userid.'" type="hidden" value="'.$member->id.'"/>';				
								echo '	<select id="jform_warmemberposition_id_'.$member->userid.'" name="jform[warmemberstate_id_'.$member->userid.']" size="1">';
								
								echo '		<option value="0" '. ($member->state == 0 ? 'selected="selected"' : '') .'>'.JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_UNKNOWN' ).'</option>';
								echo '		<option value="1" '. ($member->state == 1 ? 'selected="selected"' : '') .'>'.JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_YES' ).'</option>';
								echo '		<option value="2" '. ($member->state == 2 ? 'selected="selected"' : '') .'>'.JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_MAYBE' ).'</option>';
								echo '		<option value="3" '. ($member->state == 3 ? 'selected="selected"' : '') .'>'.JText::_( 'COM_SQUADMANAGEMENT_WARMEMBERS_STATUS_NO' ).'</option>';
									
								echo '	</select>';
									
								echo '	</td>';
								echo '	<td>';
								echo '	<input name="jform[warmemberposition_id_'.$member->userid.']" id="jform_warmemberposition_id_'.$member->userid.'" type="text" value="'.$member->position.'"/>';				
								echo '	</td>';
								echo '<td>';
								if (isset($member->comment) && $member->comment != '')
								{
									echo '<img src="'.JURI::root().'components/com_squadmanagement/images/note.png" style="width:24px; heigth: 24px;" alt="'.$member->comment.'" title="'.$member->comment.'"/>';	
								}
								echo '</td>';
								echo '</tr>';
							}	
						}						
						?>	
				</tbody>
			</table>			
		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_WARROUNDS_DETAILS' ); ?></legend>
			<div id="roundsDiv"></div>
			<div id="squadmanagementprogressing" style="display:hidden">Please Wait</div>
			<div id="squadmanagementsavefirst" style="display:hidden"><?php echo JText::_( 'COM_SQUADMANAGEMENT_EDITWAR_SAVEFIRST' ); ?></div>
		</fieldset>
					
		<input id="squadmanagementaddround" type="button" class="button" name="Add" value="Add" onclick="addRound()">

		<div id="addroundDiv"></div>
	</div>
</form>


