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

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basesquadlisttemplate.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';

class listsquadlisttemplate extends basesquadlisttemplate
{
	public function renderTemplate()
	{
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squadlist/List/style.css';
		$doc->addStyleSheet($cssHTML);
				
		if (count($this->squadlist) == 0) {
			echo 'No Squads found';
		}
		else 
		{	
			echo '<table class="squadlisttemplate_squads">';
			
			foreach ($this->squadlist as $squad) 
			{	  	
				$squadlink = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=squad&amp;id='. $squad->id );
											
				echo '<tr>';
				echo '<td class="squadlisttemplate_squad_image">';
				echo '	<a href="'.$squadlink.'" ><img src="'.JURI::base().$squad->icon.'" alt="'.$squad->name.'" title="'.$squad->name.'" /></a>';
				echo '</td>';
				echo '<td class="squadlisttemplate_squad_name" colspan="'. (count($this->fieldlist) + 2) .'">';
				echo '<a href="'.$squadlink.'" >'.$squad->name.'</a>';
				echo '</td>';
				echo '</tr>';
				
				echo '<tr class="squadlisttemplate_squadmember_tableheader">';
				echo '<td></td>';
				echo '<td>';
				echo JText::_("COM_SQUADMANAGEMENT_SQUAD_MEMBER_DISPLAYNAME");
				echo '</td>';
				echo '<td>';
				echo JText::_("COM_SQUADMANAGEMENT_SQUAD_MEMBER_ROLE");
				echo '</td>';
				
				foreach	($this->fieldlist as $field)
				{
					echo '<td>';
					echo $field->name;
					echo '</td>';
				}				
				
				echo '</tr>';			
				
				
				foreach ($squad->members as $member)
				{
					$link = IntegrationHelper::getProfileLink( $member->userid );
					
					echo '<tr class="squadlisttemplate_squadmember">';
					echo '<td class="squadlisttemplate_squadmember_image">';
					echo '<a href="'.$link.'"><img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" style="height:34px" alt="'.$member->membername.'" title="'.$member->membername.'" /></a>';
					echo '</td>';
					echo '<td class="squadlisttemplate_squadmember_name">';
					echo '<a href="'.$link.'">'.$member->membername.'</a>';
					echo '</td>';
					echo '<td>';
					echo $member->role;
					echo '</td>';
					
					foreach	($this->fieldlist as $field)
					{
						$fieldname = $field->fieldname;
						
						$value = $member->$fieldname;
						
						echo '<td>';
						echo $this->renderField($field,$member,false);
						echo '</td>';
					}
					
					echo '</tr>';	
				}
			}

			echo '</table>';
		}	
	}	
}
