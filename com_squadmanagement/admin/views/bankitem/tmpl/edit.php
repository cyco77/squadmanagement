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
JHtml::_('behavior.calendar');
JHtml::_('jquery.framework');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');
$document->addScript( JURI::base().'/components/com_squadmanagement/script/bankitem.js' );
?>

<form action="<?php echo JRoute::_('index.php?option=com_squadmanagement&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row-fluid">
		<div class="form-horizontal span7">
			<fieldset>
				<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_BANKITEM_DETAILS' ); ?></legend>
					<?php echo $this->form->getControlGroup('id'); ?>
					<?php echo $this->form->getControlGroup('itemdatetime'); ?>
					<?php echo $this->form->getControlGroup('subject'); ?>
					<?php echo $this->form->getControlGroup('userid'); ?>
					<?php echo $this->form->getControlGroup('amount'); ?>
					<?php echo $this->form->getControlGroup('type'); ?>
					<?php echo $this->form->getControlGroup('published'); ?>				
			</fieldset>	
		</div>
		<div class="form-horizontal span5" id="memberInfodue" style="display: none;">
			<fieldset>
				<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_BANKITEM_PAYED' ); ?></legend>		
				<img id="memberInfoloader" src="<?php echo JURI::root().'components/com_squadmanagement/images/loader.gif' ?>" alt="Loading" style="display:none"/>				
				<div id="memberInfo" />
			</fieldset>
		</div>
	</div>
	<div>
		<input type="hidden" name="task" value="bankitem.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

