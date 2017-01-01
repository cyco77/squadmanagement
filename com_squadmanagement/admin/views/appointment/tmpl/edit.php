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

JHtml::_('jquery.framework');
JHtml::_('behavior.tooltip');

$document = JFactory::getDocument();
$document->addScript(JURI::base().'components/com_squadmanagement/script/appointment.js');

$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');

?>

<form action="<?php echo JRoute::_('index.php?option=com_squadmanagement&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row-fluid">
		<div class="span7 form-horizontal">
			<fieldset>
				<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_FIELD_DETAILS' ); ?></legend>
				<?php echo $this->form->getControlGroup('id'); ?>
				<?php echo $this->form->getControlGroup('subject'); ?>
				<?php echo $this->form->getControlGroup('squadid'); ?>
				<?php echo $this->form->getControlGroup('type'); ?>
				<?php echo $this->form->getControlGroup('startdatetime'); ?>
				<?php echo $this->form->getControlGroup('enddatetime'); ?>
				<?php echo $this->form->getControlGroup('duration'); ?>
				<?php echo $this->form->getControlGroup('published'); ?>	
				<?php echo $this->form->getControlGroup('body'); ?>	
			</fieldset>		
		</div>
		<div class="span5 form-horizontal">
			<fieldset>
				<legend><?php echo JText::_('COM_SQUADMANAGEMENT_FIELD_DETAILS_RECURRINGAPPOINTMENT'); ?></legend>
				<div id="userecurrence">
					<label><?php echo JText::_('COM_SQUADMANAGEMENT_FIELD_DETAILS_RECURRINGAPPOINTMENT_YESNO'); ?></label>
					<input type="radio" name="isrecurringappointment" id="rad1" value="Yes" onclick="showRecurrenceControls(true)" style="float: left;margin-right: 3px;"></input> 
					<label style="float: left;margin-right: 3px;"><?php echo JText::_('JYes'); ?></label>
					<input type="radio" name="isrecurringappointment" id="rad2" value="No" checked="checked" onclick="showRecurrenceControls(false)" style="float: left;margin-right: 3px;"></input> 
					<label style="float: left;margin-right: 3px;"><?php echo JText::_('JNo'); ?></label>	
				</div>
				<div id="appointment_recurrence" style="clear: both; display:none;">
					<div class="appointment_recurrence_element">
						<label><?php echo JText::_('COM_SQUADMANAGEMENT_FIELD_DETAILS_RECURRINGAPPOINTMENT_COUNT'); ?></label>
						<input class="inputbox" type="text" id="recurrence_count" name="recurrence_count" value="1" />						
					</div>
					<div class="appointment_recurrence_element">
						<label><?php echo JText::_('COM_SQUADMANAGEMENT_FIELD_DETAILS_RECURRINGAPPOINTMENT_FREQUENCY'); ?></label>
						<select id="recurrence_frequency" name="recurrence_frequency">						
							<option value="1" selected="selected"><?php echo JText::_('COM_SQUADMANAGEMENT_FIELD_DETAILS_RECURRINGAPPOINTMENT_FREQUENCY_WEEKLY'); ?></option> 
							<option value="2"><?php echo JText::_('COM_SQUADMANAGEMENT_FIELD_DETAILS_RECURRINGAPPOINTMENT_FREQUENCY_MONTHLY'); ?></option>
							<option value="3"><?php echo JText::_('COM_SQUADMANAGEMENT_FIELD_DETAILS_RECURRINGAPPOINTMENT_FREQUENCY_YEARLY'); ?></option>
						</select>
					</div>
				</div>	
			</fieldset>
		</div>
	</div>
	
	
	
	<div>
		<input type="hidden" name="task" value="appointment.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

