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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basesquadlisttemplate.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';

class accordionsquadlisttemplate extends basesquadlisttemplate
{
	public function renderTemplate()
	{
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squadlist/Accordion/style.css';
		$doc->addStyleSheet($cssHTML);
			
		$html = array();
		
		$html[] = '<script>function showDiv(id) {jQuery("#squadlisttemplate_memberlist"+id).toggle("slow");}</script>';
			
		if (count($this->squadlist) == 0) {
			$html[] = 'No Squads found';
		}
		else 
		{	
			$i = 0;
			
			foreach ($this->squadlist as $squad) 
			{	  
				$i++;
				
				$squadlink = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=squad&amp;id='. $squad->id );
				
				$html[] = '<div class="squadlisttemplate_squad" style="clear:both;">';
				
				$html[] = '	<div class="squadlisttemplate_squad_header">';
				if ($squad->image != '')
				{
					$html[] = '		<div class="squadlisttemplate_squad_image">';
					$html[] = '			<img src="'.JURI::base().$squad->image.'" alt="'.$squad->name.'" title="'.$squad->name.'" onclick="showDiv('.$i.')" style="cursor:pointer;" />';
					$html[] = '		</div>';	
				}	
				$html[] = '	</div>';
				
				$html[] = '</div>';
				
				$html[] = '<div id="squadlisttemplate_memberlist'.$i.'" class="squadlisttemplate_memberlist" style="display:none;">';
				$html[] = '<ul>';
				foreach ($squad->members as $member)
				{
					$link = IntegrationHelper::getProfileLink( $member->userid );		
					
					$html[] = '<li>';
					$html[] = '<div class="squadlisttemplate_squadmember">';
					$html[] = '	<div class="squadlisttemplate_squadmember_name">';
					$html[] = $member->membername;
					$html[] = '	</div>';
					$html[] = '	<div class="squadlisttemplate_squadmember_image">';
					$html[] = '		<a href="'.$link.'"><img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" style="height:100px" alt="'.$member->membername.'" title="'.$member->membername.'" /></a>';
					$html[] = '	</div>';	
					$html[] = '	<div class="squadlisttemplate_squadmember_details">';
					
					$html[] = '	<div class="squadlisttemplate_squadmember_details_field">';
					$html[] = $this->getSquadMemberRole($member);
					$html[] = '	</div>';	
					
					foreach ($this->fieldlist as $field) 
					{
						$html[] = '		<div class="squadlisttemplate_squadmember_details_field">';
						$html[] = $this->renderField($field,$member);
						$html[] = '		</div>';		
					}					
					
					$html[] = '	</div>';	
					$html[] = '		<div class="squadlisttemplate_squadmember_online">';
					$html[] = $this->getLastSquadMemberOnline($member);
					$html[] = '		</div>';	
					$html[] = '</div>';	
					$html[] = '</li>';
				}
				
				$html[] = '</ul>';
				$html[] = '</div>';		
			}
		}
		
		echo implode("\n", $html); 	
	}	
}
