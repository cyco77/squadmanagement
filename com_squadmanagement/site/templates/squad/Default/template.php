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

class defaultsquadtemplate extends basesquadtemplate
{
	public function renderTemplate()
	{
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squad/Default/style.css';
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
		
		$html[] = '<div style="clear:both;"></div>';
		
		if (count($this->squad->wars) != 0) 
		{
			$warslink = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=wars&amp;limitstart=0');	
			
			$html[] = '<div><span id="warlisttemplate_wars_header">'.JText::_('COM_SQUADMANAGEMENT_LASTMATCHES').'</span><span style="float:right"><a href="'.$warslink.'">'.JText::_('COM_SQUADMANAGEMENT_MORE').'</a></span></div>';	
			
			$html[] = '<table id="warlisttemplate_wars">';
			
			$html[] = '<thead>';
			$html[] = '<tr>';
			$html[] = '	<th class="squadmanagement_wars_date" colspan="2">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_WARDATETIME'); 
			$html[] = '	</th>';			
			$html[] = '	<th class="squadmanagement_wars_opponent_image"></th>';
			$html[] = '	<th class="squadmanagement_wars_opponent">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_OPPONENT'); 
			$html[] = '	</th>';
			$html[] = '	<th class="squadmanagement_wars_league">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_LEAGUE');
			$html[] = '	</th>';
			$html[] = '	<th class="squadmanagement_wars_score">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_RESULT');
			$html[] = '	</th>';
			$html[] = '</tr>';
			$html[] = '</thead>';
			
			$html[] = '<tbody>';
						
			foreach($this->squad->wars as $i => $item)
			{
				$link = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&amp;id='. $item->id );	
				
				if ($item->state == 1)
				{				
					if ($item->score == $item->scoreopponent)
					{
						$resultclass = 'warlisttemplate_result_draw';
						$resultbackgroundclass = 'warlisttemplate_resultbackground_draw';
					}				
					if ($item->score > $item->scoreopponent)
					{
						$resultclass = 'warlisttemplate_result_win';
						$resultbackgroundclass = 'warlisttemplate_resultbackground_win';
					}
					if ($item->score < $item->scoreopponent)
					{
						$resultclass = 'warlisttemplate_result_lost';
						$resultbackgroundclass = 'warlisttemplate_resultbackground_lost';
					}
				}
				else
				{
					$resultclass = '';
					$resultbackgroundclass = 'warlisttemplate_resultbackground_challenged';	
				}
				
				$html[] = '<tr>';
				$html[] = '<td class="'.$resultbackgroundclass.'">';
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_wars_date">';
				$html[] = '<a href="'.$link.'">';				
				$html[] = JHtml::_('date', $item->wardatetime, JText::_('COM_SQUADMANAGEMENT_DATETIME'));
				$html[] = '</a>';
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_wars_opponent_image">';
				if ($item->opponentlogo != '')
				{
					$html[] = '<img src="'.JURI::root().$item->opponentlogo.'" alt="' . $item->opponent . '" />'; 	
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->opponent . '" />'; 		
				}
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_wars_opponent">';
				$html[] = $item->opponent;
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_wars_league">';
				$html[] = $item->league;
				$html[] = '</td>';				
				$html[] = '<td class="warlisttemplate_results '.$resultclass.'">';
				$html[] = $item->score . ' : ' . $item->scoreopponent;
				$html[] = '</td>';
				$html[] = '</tr>';
			}	
			
			$html[] = '<tr>';
			$html[] = '<td colspan="8">';
			$html[] = $this->renderLegend();
			$html[] = '</td>';
			$html[] = '</tr>';
			
			$html[] = '</tbody>';

			$html[] = '</table>';
		}	
		
		if (count($this->squad->awards) != 0) 
		{
			$html[] = '<br/>';
			$awardslink = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=awards&amp;limitstart=0');	
			$html[] = '<div><span id="awardstemplate_awards_header">'.JText::_('COM_SQUADMANAGEMENT_LASTAWARDS').'</span><span style="float:right"><a href="'.$awardslink.'">'.JText::_('COM_SQUADMANAGEMENT_MORE').'</a></span></div>';			
			
			$html[] = '<table id="awardstemplate_awards">';
			
			$html[] = '<thead>';
			$html[] = '<tr>';
			$html[] = '	<th></th>';
			$html[] = '	<th class="squadmanagement_awards_place" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_PLACE'); 
			$html[] = '	</th>';			
			$html[] = '	<th class="squadmanagement_awards_name" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_NAME'); 
			$html[] = '	</th>';	
			$html[] = '	<th class="squadmanagement_awards_url" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_URL');
			$html[] = '	</th>';
			$html[] = '	<th class="squadmanagement_awards_date" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_AWARDDATE');
			$html[] = '	</th>';
			$html[] = '</tr>';
			$html[] = '</thead>';
			
			$html[] = '<tbody>';
						
			$html[] = '<tbody>';	
			
			foreach($this->squad->awards as $i => $item)
			{					
								$html[] = '<tr>';
				$html[] = '<td>';

				if ($item->imageurl != '')
				{
					$html[] = '<img src="'.JURI::root().$item->imageurl.'" alt="' . $item->name . '" style="height:20px;width:20px;max-width: none;"/>'; 	
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->name . '" style="height:20px;width:20px;max-width: none;"/>'; 		
				}
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_awards_place">';
				$html[] = $item->place;
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_awards_name">';
				$html[] = '	<a href="'.$link.'" class="modal" rel="{handler: \'iframe\', size: {x: 400, y: 400}}">';
				$html[] = $item->name;
				$html[] = '</a>';				
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_awards_url">';
				if ($item->url != '')
				{
					$html[] = '<a href="'.$item->url.'">'.$item->url.'</a>'; 
				}
				$html[] = '</td>';	
				$html[] = '<td  class="squadmanagement_awards_date">';
				$html[] = JHtml::_('date', $item->awarddate, JText::_('COM_SQUADMANAGEMENT_DATE'));
				$html[] = '</td>';
				$html[] = '</tr>';
			}				
			
			$html[] = '</tbody>';

			$html[] = '</table>';
		}	
		
		echo implode("\n", $html); 	
	}	
	
	function renderLegend()
	{
		$html = array();
		
		$html[] = '<div class="squadmanagement_warcalendar_legend">';
		$html[] = '<ul>';
		$html[] = '<li><div class="warlisttemplate_resultbackground_challenged" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_CHALLENGED', 'Scheduled Game' ).'</li>';
		$html[] = '<li><div class="warlisttemplate_resultbackground_win" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_WIN', 'Win' ).'</li>';
		$html[] = '<li><div class="warlisttemplate_resultbackground_draw" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_DRAW', 'Draw' ).'</li>';
		$html[] = '<li><div class="warlisttemplate_resultbackground_lost" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_LOST', 'Lost' ).'</li>';
		$html[] = '</ul>';
		
		$html[] = '</div>';
		
		return implode("\n", $html); 	
	}
}
