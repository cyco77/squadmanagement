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

class compactsquadtemplate extends basesquadtemplate
{
	public function renderTemplate()
	{
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squad/Compact/style.css';
		$doc->addStyleSheet($cssHTML);
		
		$html = array();	
				
		$html[] = '<div style="clear:both;">';
						
		$html[] = '<div class="squadlisttemplate_squad" >';
		
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
		
		$html[] = '<div id="compact_layout" style="clear:both;">';
		$html[] = '<div id="compact_layout_right">';
		
		$html[] = '<ul class="squadlisttemplate_memberlist">';
		foreach ($this->squad->members as $member)
		{
			$link = IntegrationHelper::getProfileLink($member->userid );		
			
			$html[] = '<li>';
			$html[] = '		<a href="'.$link.'"><img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" style="height:100px" alt="'.$member->membername.'" title="'.$member->membername.'" /></a>';
			$html[] = '</li>';
		}
		$html[] = '</ul>';
		
		$html[] = '	</div>';
		$html[] = '<div id="compact_layout_left">';
		$html[] = $this->squad->description;
		
		if (count($this->squad->wars) == 0) {
			$html[] = JText::_('COM_SQUADMANAGEMENT_NO_WARS');
		}
		else 
		{	
			$html[] = '<table id="warlisttemplate_wars">';
			
			$html[] = '<thead>';
			$html[] = '<tr>';
			$html[] = '	<th style="text-align:left" colspan="2">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_WARDATETIME'); 
			$html[] = '	</th>';			
			$html[] = '	<th></th>';
			$html[] = '	<th style="text-align:left">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_OPPONENT'); 
			$html[] = '	</th>';
			$html[] = '	<th style="text-align:left">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_LEAGUE');
			$html[] = '	</th>';
			$html[] = '	<th style="text-align:left">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_RESULT');
			$html[] = '	</th>';
			$html[] = '</tr>';
			$html[] = '</thead>';
			
			$html[] = '<tbody>';
			
			$wins = 0;
			$draws = 0;
			$losts = 0;			
			
			foreach($this->squad->wars as $i => $item)
			{
				$link = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&amp;id='. $item->id );	
				
				if ($item->state == 1)
				{				
					if ($item->score == $item->scoreopponent)
					{
						$resultclass = 'warlisttemplate_result_draw';
						$resultbackgroundclass = 'warlisttemplate_resultbackground_draw';
						$draws++;
					}				
					if ($item->score > $item->scoreopponent)
					{
						$resultclass = 'warlisttemplate_result_win';
						$resultbackgroundclass = 'warlisttemplate_resultbackground_win';
						$wins++;
					}
					if ($item->score < $item->scoreopponent)
					{
						$resultclass = 'warlisttemplate_result_lost';
						$resultbackgroundclass = 'warlisttemplate_resultbackground_lost';
						$losts++;
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
				$html[] = '<td>';
				$html[] = '<a href="'.$link.'">';				
				$html[] = JHtml::_('date', $item->wardatetime, JText::_('COM_SQUADMANAGEMENT_DATETIME'));
				$html[] = '</a>';
				$html[] = '</td>';
				$html[] = '<td style="text-align: center;">';
				if ($item->opponentlogo != '')
				{
					$html[] = '<img src="'.JURI::root().$item->opponentlogo.'" alt="' . $item->opponent . '" style="height:20px;width:20px;max-width: none;"/>'; 	
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->opponent . '" style="height:20px;width:20px;max-width: none;"/>'; 		
				}
				$html[] = '</td>';
				$html[] = '<td>';
				$html[] = $item->opponent;
				$html[] = '</td>';
				$html[] = '<td>';
				$html[] = $item->leagueshortname;
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
		
		$html[] = '	</div>';
		
		$html[] = '	</div>';	
		$html[] = '	</div>';					
				
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
