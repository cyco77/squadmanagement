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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basewarlisttemplate.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php');

class defaultwarlisttemplate extends basewarlisttemplate
{
	public function renderTemplate()
	{
		$document = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/warlist/Default/style.css';
		$document->addStyleSheet($cssHTML);		
				
		$html = array();
		
		$html[] = '<div>';
		
		$html[] = '<form action="'. JRoute::_('index.php?option=com_squadmanagement&view=wars&warlisttemplate=Default&wartemplate='.$this->wartemplatename) .'" method="post" name="adminForm" id="adminForm">';
		$html[] = '<fieldset id="filter-bar">';
		$html[] = '<div class="filter-select fltrt">';
		$html[] = '	<select name="filter_squad_id" class="inputbox" onchange="this.form.submit()">';
		$html[] = JHtml::_('select.options', SquadManagementHelper::getSquadOptions(), 'value', 'text', $this->state->get('filter.squadid'));
		$html[] = '	</select>';
		$html[] = $this->pagination->getLimitBox();
		$html[] = '</div>';
		$html[] = '</fieldset>';		
		
		if (count($this->warlist) == 0) {
			$html[] = JText::_('COM_SQUADMANAGEMENT_NO_WARS');
		}
		else 
		{	
			$html[] = '<table id="warlisttemplate_wars">';
			
			$html[] = '<thead>';
			$html[] = '<tr>';
			$html[] = '	<th class="squadmanagement_wars_date" colspan="2">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_WARDATETIME'); 
			$html[] = '	</th>';			
			$html[] = '	<th class="squadmanagement_wars_squad_image"></th>';
			$html[] = '	<th class="squadmanagement_wars_squad">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_HEADING_SQUAD'); 
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
			
			$wins = 0;
			$draws = 0;
			$losts = 0;			
			
			foreach($this->warlist as $i => $item)
			{
				$link = $this->getWarlink($item->id);	
				
				if ($item->state == 1)
				{				
					switch ($item->result) 
					{
						case '0':
							$resultclass = 'warlisttemplate_result_draw';
							$resultbackgroundclass = 'warlisttemplate_resultbackground_draw';
							break;
						case '1':
							$resultclass = 'warlisttemplate_result_win';
							$resultbackgroundclass = 'warlisttemplate_resultbackground_win';
							break;
						case '-1':
							$resultclass = 'warlisttemplate_result_lost';
							$resultbackgroundclass = 'warlisttemplate_resultbackground_lost';
							break;
						default:
							$resultclass = '';
							$resultbackgroundclass = 'warlisttemplate_resultbackground_challenged';
					}
				}
				else
				{
					if ($item->state == 0)
					{
						$resultclass = '';
						$resultbackgroundclass = 'warlisttemplate_resultbackground_planned';	
					}
					else
					{
						$resultclass = '';
						$resultbackgroundclass = 'warlisttemplate_resultbackground_challenged';
					}
				}
								
				$html[] = '<tr>';
				$html[] = '<td class="'.$resultbackgroundclass.'">';
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_wars_date">';
				$html[] = '<a href="'.$link.'">';				
				$html[] = JHtml::_('date', $item->wardatetime, JText::_('COM_SQUADMANAGEMENT_DATETIME'));
				$html[] = '</a>';
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_wars_squad_image">';

				if ($item->squadlogo != '')
				{
					$html[] = '<img src="'.JURI::root().$item->squadlogo.'" alt="' . $item->squad . '" title="' . $item->squad . '" />'; 	
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->squad . '" title="' . $item->squad . '" />'; 		
				}
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_wars_squad">';
				$html[] = $item->squad;
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
		
		$html[] = '<div class="pagination">';
		$html[] = $this->pagination->getPagesLinks();
		$html[] = '</div>';				
				
		$html[] = '</form>';
		
		$html[] = '</div>';
		
		echo implode("\n", $html); 
	}	
	
	function renderLegend()
	{
		$html = array();
		
		$html[] = '<div class="squadmanagement_warcalendar_legend">';
		$html[] = '<ul>';
		$html[] = '<li><div class="warlisttemplate_resultbackground_planned" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_CHALLENGED', 'Scheduled Game' ).'</li>';
		$html[] = '<li><div class="warlisttemplate_resultbackground_win" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_WIN', 'Win' ).'</li>';
		$html[] = '<li><div class="warlisttemplate_resultbackground_draw" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_DRAW', 'Draw' ).'</li>';
		$html[] = '<li><div class="warlisttemplate_resultbackground_lost" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_LOST', 'Lost' ).'</li>';
		$html[] = '</ul>';
		
		$html[] = '</div>';
		
		return implode("\n", $html); 	
	}
}
