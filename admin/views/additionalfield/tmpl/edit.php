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

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');

JHtml::_('jquery.framework');
JHtml::_('behavior.tooltip');
?>

<form action="<?php echo JRoute::_('index.php?option=com_squadmanagement&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
	<div class="form-horizontal">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_FIELD_DETAILS' ); ?></legend>
			<?php echo $this->form->getControlGroup('id'); ?>
			<?php echo $this->form->getControlGroup('name'); ?>
			<?php echo $this->form->getControlGroup('org_fieldname'); ?>
			<?php echo $this->form->getControlGroup('fieldname'); ?>
			<?php echo $this->form->getControlGroup('org_fieldtype'); ?>
			<?php echo $this->form->getControlGroup('fieldtype'); ?>
			<?php echo $this->form->getControlGroup('org_maxlength'); ?>
			<?php echo $this->form->getControlGroup('maxlength'); ?>
			<?php echo $this->form->getControlGroup('icon'); ?>
			<?php echo $this->form->getControlGroup('showinprofile'); ?>
			<?php echo $this->form->getControlGroup('showinlist'); ?>
			<?php echo $this->form->getControlGroup('tabid'); ?>
			<?php echo $this->form->getControlGroup('published'); ?>
			<?php echo $this->form->getControlGroup('ordering'); ?>
		</fieldset>			
	</div>
	<div>
		<input type="hidden" name="task" value="additionalfield.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

