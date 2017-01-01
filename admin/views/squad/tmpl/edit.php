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

$document->addScript( JURI::base().'components/com_squadmanagement/script/squad.js' );
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/squad.css');

?>
 <div class="row-fluid">
	<div class="span7">
		<form action="<?php echo JRoute::_('index.php?option=com_squadmanagement&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
			<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_SQUAD_DETAILS' ); ?></legend>
			<div class="form-horizontal">
				<?php echo $this->form->getControlGroup('id'); ?>
				<?php echo $this->form->getControlGroup('shortname'); ?>
				<?php echo $this->form->getControlGroup('name'); ?>
				<?php echo $this->form->getControlGroup('catid'); ?>
				<?php echo $this->form->getControlGroup('squadleader'); ?>
				<?php echo $this->form->getControlGroup('waradmin'); ?>
				<?php echo $this->form->getControlGroup('ismanagementsquad'); ?>
				<?php echo $this->form->getControlGroup('icon'); ?>
				<?php echo $this->form->getControlGroup('image'); ?>
				<?php echo $this->form->getControlGroup('published'); ?>				
			</div>
			<div class="clr"></div>
			<?php echo $this->form->getLabel('description'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('description'); ?>
			</fieldset>
			<div>
				<input type="hidden" name="task" value="squad.edit" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</form>
	</div>
	
	<div class="form-horizontal span5">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_SQUADMANAGEMENT_SQUAD_DETAILS_MEMBERS' ); ?></legend>				
				
			<?php
				
			if (isset($this->item->id))
			{
					
			?>
					
			<table class="table table-striped">
			<thead>
			<tr>
				<th style="text-align:left;width:30px;"></th>
				<th style="text-align:left;width:45%;">
					<?php echo JText::_('COM_SQUADMANAGEMENT_SQUADMEMBER_HEADING_NAME'); ?>
				</th>
				<th style="text-align:left;width:40%;">
					<?php echo JText::_('COM_SQUADMANAGEMENT_SQUADMEMBER_HEADING_ROLE'); ?>
				</th>
				<th>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php
			if (isset($this->members) && $this->members != null)
			{
				foreach	($this->members as $i => $member)
				{
					echo '<tr class="row'. $i % 2 .'">';
					echo '<td>';
					echo '<img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" alt="' . $member->name . '" style="height:30px;width:20px;min-width:20px;"/>'; 
					echo '</td>';
					echo '<td>';					
					echo '<a href="'.JRoute::_('index.php?option=com_squadmanagement&controller=squadmembers&task=squadmember.edit&id=' . $member->id) . '">';
					echo $member->name;
					echo '</a>';
					echo '</td>';
					echo '<td>';
					echo $member->role;
					echo '</td>';
					echo '<td>';
					echo '<a href="'.JRoute::_('index.php?option=com_squadmanagement&controller=squadmembers&task=removemember&id=' . $member->id . '&squadid=' .$this->item->id ) . '">';
					echo JText::_('COM_SQUADMANAGEMENT_SQUADMEMBER_DELETE');
					echo '</a>';
					echo '</td>';
					echo '</tr>';
				}
			}
			?>		
</tbody>					
</table>					
<hr />	
			<div id="userlookupcaption">
				<span ><?php echo JText::_('COM_SQUADMANAGEMENT_USERLOOKUP_CAPTION'); ?></span>
			</div>
			<form action="<?php echo JRoute::_('index.php?option=com_squadmanagement&view=squad&layout=edit&task=addmember&id='.(int) $this->item->id); ?>" method="post" name="adminsquadmemberForm" id="squadmember-form">
				<table>
						<tr>					
							<td>
								UserID
							</td>
							<td>
								<?php echo JText::_('COM_SQUADMANAGEMENT_USERLOOKUP_NAME'); ?>
							</td>
							<td>
								<?php echo JText::_('COM_SQUADMANAGEMENT_USERLOOKUP_ROLE'); ?>
							</td>
							<td>
							</td>
						</tr>
						<tr>					
							<td>
								<input type="text" name="userid" style="width: 30px;" />
							</td>
							<td>
								<input id="username" autocomplete="off" name="username" type="text" style="width: 120px;" />
							</td>
							<td>
								<input name="role" type="text" style="width: 160px;"/>
							</td>
							<td>
								<input name="addmember" type="submit" value="<?php echo JText::_('COM_SQUADMANAGEMENT_USERLOOKUP_ADDMEMBER'); ?>" />
</td>
</tr>
</table>
</form>		
			<img id="usernamesugestionsloader" src="<?php echo JURI::root().'components/com_squadmanagement/images/loader.gif' ?>" alt="Loading" style="display:none"/>				
			<div id="usernamesugestions"  >
			</div>
			
			<?php
			}	
			else{
				echo JText::_('COM_SQUADMANAGEMENT_USERLOOKUP_SAVEFIRST');
			}
			?>
			
		</fieldset>		
	</div>
</div>