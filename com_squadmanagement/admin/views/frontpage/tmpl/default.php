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

// load tooltip behavior
JHtml::_('behavior.tooltip');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'componenthelper.php');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');

$canDo = SquadmanagementHelper::getActions();

?>

<div class="squadmanagement_frontpage">
	<div class="span7" style="float:left;">
			<?php
		if ($canDo->get('com_squadmanagement.squad'))
		{
		?>
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_categories&extension=com_squadmanagement" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_CATEGORIES'); ?>">
					<div>
						<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/squadcategories.png" alt="" style="margin-top:15px;">
					</div>
					<div>
						<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_CATEGORIES'); ?></span>
					</div>
				</a>
			</div>
		</div>	
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=squads" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_SQUADS'); ?>">
					<div>
						<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/squads.png" alt="" style="margin-top:15px;">
					</div>
					<div>
						<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_SQUADS'); ?></span>
					</div>
				</a>
			</div>
		</div>
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=squadmembers" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_SQUADMEMBERS'); ?>">
					<div>
						<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/squadmembers.png" alt="" style="margin-top:15px;">
					</div>
					<div>
						<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_SQUADMEMBERS'); ?></span>
					</div>
					<?php if ($this->trialcount > 0)
					{
						echo '<span class="squadmanagement-badge">'.$this->trialcount.'</span>';
					}
					?>
				</a>
			</div>
		</div>
		<?php
		}
		if ($canDo->get('com_squadmanagement.field'))
		{
		?>		
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=additionaltabs" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_TABS'); ?>">
					<div>
						<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/infotabs.png" alt="" style="margin-top:15px;">
					</div>
					<div>
						<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_TABS'); ?></span>
					</div>
				</a>
			</div>
		</div>
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=additionalfields" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_FIELDS'); ?>">
					<div>
						<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/infofields.png" alt="" style="margin-top:15px;">
					</div>
					<div>
						<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_FIELDS'); ?></span>
					</div>
				</a>
			</div>
		</div>
		<?php
		}
		if ($canDo->get('com_squadmanagement.league'))
		{
		?>		
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=leagues" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_LEAGUES'); ?>">
				<div>
					<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/league.png" alt="" style="margin-top:15px;">
				</div>
				<div>
					<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_LEAGUES'); ?></span>
				</div>
				</a>
			</div>
		</div>
		<?php
		}
		if ($canDo->get('com_squadmanagement.opponent'))
		{
		?>		
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=opponents" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_OPPONENTS'); ?>">
				<div>
					<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/opponents.png" alt="" style="margin-top:15px;">
				</div>
				<div>
					<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_OPPONENTS'); ?></span>
				</div>
				</a>
			</div>
		</div>
		<?php
		}
		if ($canDo->get('com_squadmanagement.war'))
		{
		?>		
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=wars" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_WARS'); ?>">
				<div>
					<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/wars.png" alt="" style="margin-top:15px;">
				</div>
				<div>
					<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_WARS'); ?></span>					
				</div>
				<?php if ($this->challengecount > 0)
				{
					echo '<span class="squadmanagement-badge">'.$this->challengecount.'</span>';
				}
				?>
				</a>
			</div>
		</div>
		<?php
		}
		if ($canDo->get('com_squadmanagement.appointment'))
		{
		?>		
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=appointments" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_APPOINTMENTS'); ?>">
				<div>
					<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/appointments.png" alt="" style="margin-top:15px;">
				</div>
				<div>
					<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_APPOINTMENTS'); ?></span>					
				</div>
				</a>
			</div>
		</div>		
		<?php
		}
	if ($canDo->get('com_squadmanagement.award'))
		{
		?>					
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=awards" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_AWARDS'); ?>">
				<div>
					<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/awards.png" alt="" style="margin-top:15px;">
				</div>
				<div>
					<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_AWARDS'); ?></span>					
				</div>
				</a>
			</div>
		</div>		
				<?php
		}
	if ($canDo->get('com_squadmanagement.bankitem'))
		{
		?>	
		<div class="squadmanagement_frontpage_section">
			<div class="squadmanagement_frontpage_section_inner">
				<a href="index.php?option=com_squadmanagement&view=bankitems" title="<?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_BANKITEMS'); ?>">
				<div>
					<img src="<?php echo JURI::root(); ?>administrator/components/com_squadmanagement/images/bankitems.png" alt="" style="margin-top:15px;">
				</div>
				<div>
					<span><?php echo JText::_('COM_SQUADMANAGEMENT_SUBMENU_BANKITEMS'); ?></span>					
				</div>
				</a>
			</div>
		</div>		
		<?php
	}
	?>					
	</div>
		<div class="span5" style="float:left;">
			<div style="border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
				<div style="float:right;margin:10px;">
					<?php echo JHTML::_('image', 'administrator/components/com_squadmanagement/images/logo_96.png', 'SquadManagement!' );?>
				</div>
			
				<h3>SquadManagement!</h3>
				<p>Version: <?php echo Componenthelper::getVersion() ?></p>

				<p>© 2012 - <?php echo date("Y") ?> Lars Hildebrandt</p>
				<p><a href="http://joomla.larshildebrandt.de/" target="_blank">joomla.larshildebrandt.de</a></p>
				
				<hr></hr>	
				<p><?php echo JText::_('COM_SQUADMANAGEMENT_DONATE'); ?></p>
				<div class="paypal_donation">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="business" value="cyco@punk-and-roll.de">
						<input type="hidden" name="item_name" value="joomla.larshildebrandt - SquadManagement">
						<input type="hidden" name="no_shipping" value="0">
						<input type="hidden" name="no_note" value="1">
						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="tax" value="0">
						<input type="hidden" name="bn" value="PP-DonationsBF">
						<input type="hidden" name="amount" value="">   
						<input style="border:0;" type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal Donation">            
						<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div>
				
				<?php 
				/*if ($this->challengecount > 0)
				{
					if ($this->challengecount == 1)
					{
						echo JText::_('COM_SQUADMANAGEMENT_N_CHALLENGES_1');
					}
					else
					{
						echo JText::plural('COM_SQUADMANAGEMENT_N_CHALLENGES_MORE', $this->challengecount);
					}
				}			*/
							
				?>
				
			</div>
			
		</div>
	</div>

