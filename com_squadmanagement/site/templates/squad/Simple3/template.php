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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basesquadtemplate.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';

class simple3squadtemplate extends basesquadtemplate
{
	public function renderTemplate()
	{
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squad/Simple3/style.css';
		$doc->addStyleSheet($cssHTML);
		
		$html = array();	
					
		$html[] = '<div class="squadlisttemplate_memberlist">';
		$html[] = '<ul>';
		foreach ($this->squad->members as $member)
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
		
		$html[] = '<div style="clear:both;"></div>';
		
		
		echo implode("\n", $html); 	
	}	
}
