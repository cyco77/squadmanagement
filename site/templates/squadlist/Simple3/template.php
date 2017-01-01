<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squadmanagement!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2012 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://joomla.larshildebrandt.de
# Technical Support:  Forum - http://joomla.larshildebrandt.de/forum/index.html
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basesquadlisttemplate.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';

JHTML::_('behavior.tooltip');

class simple3squadlisttemplate extends basesquadlisttemplate
{
	public function renderTemplate()
	{
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squadlist/Simple3/style.css';
		$doc->addStyleSheet($cssHTML);
		$doc->addStyleSheet('http://fonts.googleapis.com/css?family=Ranchers');
			
		$html = array();
			
		if (count($this->squadlist) == 0) {
			$html[] = 'No Squads found';
		}
		else 
		{	
			foreach ($this->squadlist as $squad) 
			{	  
				$squadlink = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=squad&amp;id='. $squad->id );
				
				$html[] = '<div class="squadlisttemplate_squad" style="clear:both;">';
				
				$html[] = '	<div class="squadlisttemplate_squad_header">';
				if ($squad->image != '')
				{
					$html[] = '		<div class="squadlisttemplate_squad_image">';
					$html[] = '			<a href="'.$squadlink.'" ><img src="'.JURI::base().$squad->image.'" alt="'.$squad->name.'" title="'.$squad->name.'" /></a>';
					$html[] = '		</div>';	
				}
				$html[] = '		<div class="squadlisttemplate_squad_name">';
				$html[] = '			<a href="'.$squadlink.'" ><span >'.$squad->name.'</span></a>';
				$html[] = '		</div>';
				$html[] = '	</div>';
				
				$html[] = '</div>';
				
				$html[] = '<div class="squadlisttemplate_memberlist">';
				$html[] = '<ul>';
				foreach ($squad->members as $member)
				{
					$link = IntegrationHelper::getProfileLink( $member->userid );		
					
					$html[] = '<li>';
					
					$html[] = '<div class="squadlisttemplate_squadmember">';

					$html[] = '	<div class="squadlisttemplate_squadmember_image">';
					$html[] = '		<a href='.$link.'><img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" style="height:152px" alt="'.$member->membername.'" title="'.$member->membername.'" /></a>';
					$html[] = '	</div>';	
					
					$html[] = '	<div class="squadlisttemplate_squadmember_name">';
					$html[] = $member->membername;
					$html[] = '	</div>';
					
					$html[] = '	<div class="squadlisttemplate_squadmember_details_field">';
					$html[] = $member->role;
					$html[] = '	</div>';
					
					$html[] = '	</div>';
					
					$html[] = '</li>';
				}
				$html[] = '</ul>';
				$html[] = '</div>';						
			}
		}
		
		echo implode("\n", $html); 	
	}	
}
