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

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');
?>

<form action="<?php echo JRoute::_('index.php?option=com_squadmanagement&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
	<div class="form-horizontal">
		<fieldset>
			<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_LEAGUE_DETAILS' ); ?></legend>
			<?php echo $this->form->getControlGroup('id'); ?>
			<?php echo $this->form->getControlGroup('name'); ?>
			<?php echo $this->form->getControlGroup('shortname'); ?>
			<?php echo $this->form->getControlGroup('logo'); ?>
			<?php echo $this->form->getControlGroup('url'); ?>
			<?php echo $this->form->getControlGroup('published'); ?>
			<?php echo $this->form->getControlGroup('ordering'); ?>					
		</fieldset>			
	</div>
	<div>
		<input type="hidden" name="task" value="league.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

