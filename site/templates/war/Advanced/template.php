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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basewartemplate.php');

JHTML::_('behavior.tooltip');
JHtml::_('jquery.framework');

class advancedwartemplate extends basewartemplate
{
	public function renderTemplate()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_squadmanagement/templates/war/Advanced/style.css');			
		$document->addStyleSheet(JURI::base().'components/com_squadmanagement/script/slimbox/css/slimbox2.css');		
		$document->addScript( JURI::root().'components/com_squadmanagement/script/slimbox/js/slimbox2.js' );
		
		$html = array();
						
		$html[] = '<div id="wartemplate_teams_border">';
		$html[] = '<table id="wartemplate_teams">';
		$html[] = '	<tr>';
		$html[] = '		<td class="wartemplate_left wartemplate_teams_header">';
		$html[] = $this->war->squad;
		$html[] = '		</td>';
		$html[] = '		<td class="wartemplate_middle wartemplate_score">';
		
		$html[] = '		</td>';
		$html[] = '		<td class="wartemplate_right wartemplate_teams_header">';
		$html[] = $this->war->opponent;
		$html[] = '		</td>';	
		$html[] = '	</tr>';		
		// Squad & OpponentNames
		$html[] = '	<tr>';
		$html[] = '		<td class="wartemplate_left wartemplate_teams_logo">';
		if ($this->war->squadlogo != '')
		{
			$html[] = '<img src="'.JURI::root().$this->war->squadlogo.'" alt="' . $this->war->squad . '" style="height:64px;width:64px;" /><br />'; 	
		}
		else
		{
			$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $this->war->squad . '" style="height:64px;width:64px;" /><br />'; 		
		}
		$html[] = '		</td>';
		$html[] = '		<td class="wartemplate_middle wartemplate_score">';	
		$html[] = '			vs';	
		$html[] = '		</td>';
		$html[] = '		<td class="wartemplate_right wartemplate_teams_logo">';
		if ($this->war->opponentlogo != '')
		{
			$html[] = '<img src="'.JURI::root().$this->war->opponentlogo.'" alt="' . $this->war->opponent . '" style="height:64px;width:64px;" /><br />'; 	
		}
		else
		{
			$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $this->war->opponent . '" style="height:64px;width:64px;" /><br />'; 		
		}
		$html[] = '		</td>';	
		$html[] = '	</tr>';
		// Result
		
		$squadresultclass = '';
		$oppontentresultclass = '';
		if ($this->war->score != '' && $this->war->scoreopponent != '')
		{
			if ($this->war->state == 1)
			{
				$squadresultclass = 'wartemplate_result_draw';
				$oppontentresultclass = 'wartemplate_result_draw';
			}				
			if ($this->war->score > $this->war->scoreopponent)
			{
				$squadresultclass = 'wartemplate_result_win';
				$oppontentresultclass = 'wartemplate_result_lost';
			}
			if ($this->war->score < $this->war->scoreopponent)
			{
				$squadresultclass = 'wartemplate_result_lost';
				$oppontentresultclass = 'wartemplate_result_win';
			}	
		}		
		
		$html[] = '	<tr>';
		$html[] = '		<td class="wartemplate_left wartemplate_teams_result">';
		$html[] = '<div class="'.$squadresultclass.'">'.$this->war->score.'</div>';
		$html[] = '		</td>';
		$html[] = '		<td class="wartemplate_middle">';
		$html[] = '		</td>';
		$html[] = '		<td class="wartemplate_right wartemplate_teams_result">';
		$html[] = '<div class="'.$oppontentresultclass.'">'.$this->war->scoreopponent.'</div>';	
		$html[] = '		</td>';	
		$html[] = '	</tr>';
		// Lineup		
		$html[] = '	<tr>';
		$html[] = '		<td class="wartemplate_left wartemplate_players wartemplate_teams_lineup" valign="top">';
		if (count($this->war->members) == 0)
		{			
			$lineup = explode(",", $this->war->lineup);
			
			foreach ($lineup as $player)
			{
				$html[] = $player.'<br />';
			}
		}
		else
		{
			$html[] = ' 		<div style="width:100%">';			
			foreach ($this->war->members as $member)
			{
				$html[] = ' 		<div style="float:left; textalign:center;margin:3px;">';				
				$image = IntegrationHelper::getFullAvatarImagePath($member->avatar);
				$width = ImageHelper::getImageWidth($image,80);

				$html[] = ' 			<div style="clear:both;">';			
				$html[] = ' 				<img src="'.$image.'" style="height:80px;width:'.$width.'px" title="'.$member->membername.'" alt="'.$member->membername.'"/>'; 
				$html[] = ' 			</div>';
				$html[] = ' 		</div>';
			}	
			
			$html[] = ' 		</div>';
		}
		$html[] = '		</td>';
		$html[] = '		<td class="wartemplate_middle">';
		$html[] = '		</td>';
		$html[] = '		<td class="wartemplate_right wartemplate_players wartemplate_teams_lineup" valign="top">';
		$lineup = explode(",", $this->war->lineupopponent);
		
		$html[] = ' 		<div style="width:100%">';			
		foreach ($lineup as $player)
		{
			$html[] = ' 		<div style="float:right; textalign:center;margin:3px;">';				
			$html[] = ' 			<div style="clear:both;">';			
			$html[] = ' 				<img src="'.JURI::root().'components/com_squadmanagement/images/unknownuser.jpg" style="height:80px;width:53px" title="'.$player.'" alt="'.$player.'"/>'; 
			$html[] = ' 			</div>';
			$html[] = ' 		</div>';
		}		
		$html[] = ' 		</div>';
			
		$html[] = '		</td>';	
		$html[] = '	</tr>';
		$html[] = '</table>';			
		$html[] = '</div>';	
		
		$html[] = '<br />';				
		
		$html[] = '<div id="wartemplate_teams_border">';
		$html[] = '<table id="wartemplate_data">';
		$html[] = '	<tr>';		
		$html[] = '		<th colspan="3">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_DETAILS');
		$html[] = '		</th>';
		$html[] = '	</tr>';
		$html[] = '	<tr>';			
		$html[] = '		<td>';
		$html[] = '			<img src="'.JURI::root().'components/com_squadmanagement/images/date.png" alt="" style="height:24px;width:24px;max-width:none;"/><br />';
		$html[] = '		</td>';	
		$html[] = '		<td class="wartemplate_data_caption">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_WARDATETIME');
		$html[] = '		</td>';	
		$html[] = '		<td class="wartemplate_data_value">';	
		$html[] = JHtml::_('date', $this->war->wardatetime, JText::_('COM_SQUADMANAGEMENT_DATETIME'));
		$html[] = '		</td>';		
		$html[] = '	</tr>';
		$html[] = '	<tr>';			
		$html[] = '		<td>';
		if ($this->war->leaguelogo != '')
		{
			$html[] = '<img src="'.JURI::root().$this->war->leaguelogo.'" alt="' . $this->war->league . '" style="height:24px;width:24px;max-width:none;"/><br />'; 	
		}
		else
		{
			$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $this->war->opponent . '" style="height:24px;width:24px;max-width:none;"/><br />'; 		
		}
		$html[] = '		</td>';	
		$html[] = '		<td class="wartemplate_data_caption">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_LEAGE');
		$html[] = '		</td>';	
		$html[] = '		<td class="wartemplate_data_value">';	
		if ($this->war->matchlink)
		{				
			$html[] = '<a href="'.$this->war->matchlink.'">'.$this->war->league.'</a>';
		}
		else
		{
			$html[] =  $this->war->league;
		}
		$html[] = '		</td>';		
		$html[] = '	</tr>';
		$html[] = '	<tr>';			
		$html[] = '		<td>';
		$html[] = '			<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="" style="height:24px;width:24px;"/><br />';
		$html[] = '		</td>';	
		$html[] = '		<td class="wartemplate_data_caption">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_DESCRIPTION');
		$html[] = '		</td>';	
		$html[] = '		<td class="wartemplate_data_value">';	
		$html[] =  $this->war->description;
		$html[] = '		</td>';		
		$html[] = '	</tr>';	
		
		$html[] = '</table>';
		$html[] = '</div>';	
		
		$html[] = '<br />';	
		
		if (count($this->war->rounds) > 0)
		{		
			$html[] = '<div id="wartemplate_teams_border">';
			$html[] = '<table id="wartemplate_rounds">';
			$html[] = '	<tr>';		
			$html[] = '		<th colspan="7">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_ROUNDS');
			$html[] = '		</th>';
			$html[] = '	</tr>';			
		
			$roundnr = 0;		
			foreach ($this->war->rounds as $round)
			{
				$roundnr++;
				$html[] = '<tr>';	
				$html[] = '<td width="20px">';
				$html[] = '</td>';
				$html[] = '<td>';
				$html[] = $round->map;
				$html[] = '</td>';
				$html[] = '<td class="wartemplate_rounds_map">';
				
				if ($round->mapimage != '')
				{
					$html[] = '<img src="'.JURI::root().$round->mapimage.'" alt="' . $round->map . '" title="' . $round->map . '" style="max-width:150px"/>'; 	
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/nomapimage.jpg" alt="' . $round->map . '" style="max-width:150px"/>'; 		
				}
				
				$html[] = '</td>';
				$html[] = '<td class="wartemplate_rounds_score">';
				
				$html[] = $round->score . ' : ' . $round->score_opponent;
				
				$html[] = '</td>';
				$html[] = '<td class="wartemplate_rounds_screenshot">';
				
				if ($round->screenshot != '')
				{	
					$parts = pathinfo(JURI::root().$round->screenshot);		
					$imagepath = $parts['dirname'].'/thumbs/'.$parts['basename'];
					
					$html[] = '<a href="'.$imagepath.'" rel="lightbox-screens" title="'. $round->map . ' - ' . $round->score . ' : ' . $round->score_opponent . '" >';
					$html[] = '<img src="'.JURI::root().$round->screenshot.'" alt="' . $imagepath . '" title="' . $round->screenshot . '" style="max-width:150px"/>'; 	
					$html[] = '</a>';
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="" title="" style="max-width:150px"/>'; 		
				}	
				
				$html[] = '</td>';
				$html[] = '<td width="100%">';
				$html[] = '</td>';
				$html[] = '</tr>';
			}
			$html[] = '</table>';
			$html[] = '</div>';	
			
			$html[] = '<br />';	
		}
		
		// Trend
		$html[] = '<div id="wartemplate_teams_border">';
		$html[] = '<div class="trend">';	
		$html[] = '<div class="trendbegin">';
		$html[] = '<span class="trendbegin_win">W</span>';	
		$html[] = '<span class="trendbegin_draw">D</span>';	
		$html[] = '<span class="trendbegin_lost">L</span>';	
		$html[] = '</div>';	
		
		$startleft = 30;
		$lastresult = '';	
		$lineclass = '';
		$no = 0;
			
		foreach ($this->war->history as $war)			
		{			
			$no++;
			
			$link = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&amp;id='. $war->id );	
			
			if ($war->opponentlogo != '')
			{
				$logo = '<img src="'.JURI::root().$war->opponentlogo.'" alt="' . $war->opponent . '" style="height:24px;width:24px;" /><br />'; 	
			}
			else
			{
				$logo = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $war->opponent . '" style="height:24px;width:24px;" /><br />'; 		
			}
			
			$tooltip = $war->opponent.'::'.JHtml::_('date', $war->wardatetime, JText::_('COM_SQUADMANAGEMENT_DATETIME'));
			
			if ($war->score == $war->scoreopponent)
			{
				$link = '<a class="trendopponentlink hasTip" title="'.$tooltip.'" href="'.$link.'" style="top:88px; left:'.$startleft.'px;">'.$logo.'</a>';
				$lineclass = $lastresult.'_draw';
				$lastresult = 'draw';	
			}				
			if ($war->score > $war->scoreopponent)
			{
				$link = '<a class="trendopponentlink hasTip" title="'.$tooltip.'" href="'.$link.'" style="top:15px; left:'.$startleft.'px;">'.$logo.'</a>';
				$lineclass = $lastresult.'_win';
				$lastresult = 'win';
			}
			if ($war->score < $war->scoreopponent)
			{
				$link = '<a class="trendopponentlink hasTip" title="'.$tooltip.'" href="'.$link.'" style="top:161px; left:'.$startleft.'px;">'.$logo.'</a>';
				$lineclass = $lastresult.'_lost';
				$lastresult = 'lost';
			}
			
			if ($no > 1)
			{
				$html[] = '<div class="trendelement '.$lineclass.'" style="left:50px;">';
				$html[] = '</div>';
			}
			
		    $html[] = $link;	
			
			$startleft += 60;				
		}
		
		
		$html[] = '</div>';	
		$html[] = '</div>';	
		
		$usejcomments = $this->params->get('usejcomments','1');
		$comments = JPATH_SITE . DIRECTORY_SEPARATOR .'components' . DIRECTORY_SEPARATOR . 'com_jcomments' . DIRECTORY_SEPARATOR . 'jcomments.php';
		if ($usejcomments == '1' && file_exists($comments)) 
		{			
			require_once($comments);
		
			$html[] = '<div style="clear:both"></div>';	
			$title = JHtml::_('date', $this->war->wardatetime, JText::_('COM_SQUADMANAGEMENT_DATETIME')) . ' ' . $this->war->squad . ' : ' . $this->war->opponent;
			$html[] = JComments::showComments($this->war->id, 'com_squadmanagement', $title);			
		}		
				
		echo implode("\n", $html); 		
	}	
}
