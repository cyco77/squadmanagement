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
	<div class="row-fluid">
		<div class="form-horizontal span7">
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_SQUADMEMBER_DETAILS' ); ?></legend>
				<?php echo $this->form->getControlGroup('published'); ?>
				<?php echo $this->form->getControlGroup('id'); ?>
				<?php echo $this->form->getControlGroup('userid'); ?>
				<?php echo $this->form->getControlGroup('displayname'); ?>
				<?php echo $this->form->getControlGroup('steamid'); ?>
				<?php echo $this->form->getControlGroup('memberstate'); ?>
				<?php echo $this->form->getControlGroup('role'); ?>
				<?php echo $this->form->getControlGroup('joinusdescription'); ?>
				<?php echo $this->form->getControlGroup('imageurl'); ?>
				<?php echo $this->form->getControlGroup('description'); ?>
			</fieldset>
		</div>
		<div class="form-horizontal span5">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_SQUADMEMBER_BANK' ); ?></legend>
				<?php	
			
				$attributes = array();
				$attributes['size'] = 20;
			
				echo '<div class="control-group">';
				echo '	<div class="control-label">';
				echo '		<label id="jform_fromdate-lbl" for="jform_fromdate" class="required" title="">'.JText::_( 'COM_SQUADMANAGEMENT_SQUADMEMBER_FROMDATE' ).'</label>';
				echo '	</div>';
				echo '	<div class="controls">';
				echo		JHtml::_('calendar', $this->item->fromdate, 'jform[fromdate]', 'fromdate', '%Y-%m-%d',$attributes);
				echo '	</div>';
				echo '</div>';
			
				echo '<div class="control-group">';
				echo '	<div class="control-label">';
				echo '		<label id="jform_dues-lbl" for="jform_dues" class="required" title="">'.JText::_( 'COM_SQUADMANAGEMENT_SQUADMEMBER_DUES' ).'</label>';
				echo '	</div>';
				echo '	<div class="controls">';
				echo '		<input type="text" name="jform[dues]" id="jform_dues" value="'.$this->item->dues.'" size="40" />';
				echo '	</div>';
				echo '</div>';
				
				echo '<div class="control-group">';
				echo '	<div class="control-label">';
				echo '		<label id="jform_payedto-lbl" for="jform_payedto" class="required" title="">'.JText::_( 'COM_SQUADMANAGEMENT_SQUADMEMBER_PAYEDTO' ).'</label>';
				echo '	</div>';
				echo '	<div class="controls">';
				echo		JHtml::_('calendar', $this->item->payedto, 'jform[payedto]', 'jform_payedto', '%Y-%m-%d',$attributes);
				echo '	</div>';
				echo '</div>';
				
				?>
			</fieldset>

			<fieldset class="adminform">
				<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_SQUADMEMBER_ADDITIONAL' ); ?></legend>
				<?php		
					
				$lastTab = '<<unknown>>';	
				$fields = get_object_vars($this->item);		
					
				foreach ($this->additionalFields as $additionalfield)
				{
					if ($lastTab != $additionalfield->tabname)
					{
						$tabname = $additionalfield->tabname != null ? $additionalfield->tabname : JText::_('COM_SQUADMANAGEMENT_TAB_COMMON');	
														
						echo '<div><b>'.$tabname.'</b></div>';	
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
								echo '<div class="control-group">';
								echo '	<div class="control-label">';
								echo '		<label id="jform_'.$name.'-lbl" for="jform_'.$name.'" class="required" title="">'.$additionalfield->name.'</label>';
								echo '	</div>';
								echo '	<div class="controls">';
								echo '		<input type="text" name="jform['.$name.']" id="jform_'.$name.'" value="'.$this->item->$name.'" size="40" />';
								echo '	</div>';
								echo '</div>';
							}				
						}						
					}
				}			

				?>		
			</fieldset>
		</div>
	</div>
	<div>
		<input type="hidden" name="task" value="squadmember.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
