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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basesquadtemplate.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';

class simplewithsquadleadersquadtemplate extends basesquadtemplate
{
	public function renderTemplate()
	{
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squad/SimpleWithSquadLeader/style.css';
		$doc->addStyleSheet($cssHTML);
		
		$html = array();	
		
		$html[] = '<div class="squadlisttemplate_squad" style="clear:both;">';
		
		$html[] = '	<div class="squadlisttemplate_squad_header">';
		if ($this->squad->image != '')
		{
			$html[] = '		<div class="squadlisttemplate_squad_image">';
			$html[] = '			<img src="'.JURI::base().$this->squad->image.'" alt="'.$this->squad->name.'" title="'.$this->squad->name.'" />';
			$html[] = '		</div>';	
		}
		$html[] = '		<div class="squadlisttemplate_squad_name">';
		$html[] = '			<span >'.$this->squad->name.'</span>';
		$html[] = '		</div>';
		$html[] = '	</div>';
		
		$html[] = '</div>';
		
		if (trim($this->squad->description) != '')
		{
			$html[] = '<div>';
			$html[] = $this->squad->description;
			$html[] = '</div>';	
		}
		
		$html[] = '<div class="squadlisttemplate_memberlist">';
		$html[] = '<ul>';
		foreach ($this->squad->members as $member)
		{
			$link = IntegrationHelper::getProfileLink( $member->userid );	
				
			$html[] = '<li>';
			$html[] = '<div class="squadlisttemplate_squadmember">';
			$html[] = '	<div class="squadlisttemplate_squadmember_image">';
			if ($this->squad->squadleader == $member->userid)
			{
				$html[] = '<div class="squadlisttemplate_squadleader"></div>';
			}
			
			if ($this->squad->waradmin == $member->userid)
			{
				$html[] = '<div class="squadlisttemplate_matchadmin"></div>';
			}
				
			$html[] = '		<a href="'.$link.'"><img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" style="height:180px" alt="'.$member->membername.'" title="'.$member->membername.'" /></a>';
			$html[] = '	</div>';								
			$html[] = '</div>';
			$html[] = '</li>';
		}
		$html[] = '</ul>';
		$html[] = '</div>';	
			
		$html[] = '<div style="clear:both;"/>';
		
		echo implode("\n", $html); 	
	}	
}
