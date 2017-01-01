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

class defaultwartemplate extends basewartemplate
{
	public function renderTemplate()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_squadmanagement/templates/war/Default/style.css');			
		$document->addStyleSheet(JURI::base().'components/com_squadmanagement/script/slimbox/css/slimbox2.css');		
		$document->addScript( JURI::root().'components/com_squadmanagement/script/slimbox/js/slimbox2.js' );
		
		$html = array();
						
		$html[] = '<div id="wartemplate_teams_border">';
		$html[] = '<table id="wartemplate_teams">';
		$html[] = '	<tr>';
		$html[] = '		<td id="wartemplate_left">';
		if ($this->war->squadlogo != '')
		{
			$html[] = '<img src="'.JURI::root().$this->war->squadlogo.'" alt="' . $this->war->squad . '" style="height:24px;width:24px;"/><br />'; 	
		}
		else
		{
			$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $this->war->squad . '" style="height:24px;width:24px;"/><br />'; 		
		}
		$html[] = $this->war->squad;
		$html[] = '		</td>';
		$html[] = '		<td id="wartemplate_middle" class="wartemplate_score">';
		
		if ($this->war->state == 1)
		{
			if ($this->war->score == $this->war->scoreopponent)
			{
				$resultclass = 'wartemplate_result_draw';
			}				
			if ($this->war->score > $this->war->scoreopponent)
			{
				$resultclass = 'wartemplate_result_win';
			}
			if ($this->war->score < $this->war->scoreopponent)
			{
				$resultclass = 'wartemplate_result_lost';
			}	
			
			$html[] = '<span class="'.$resultclass.'">'.$this->war->score . ' : '. $this->war->scoreopponent.'</span>';
		}
		else
		{
			$html[] = ':';
		}
		$html[] = '		</td>';
		$html[] = '		<td id="wartemplate_right">';
		if ($this->war->opponentlogo != '')
		{
			$html[] = '<img src="'.JURI::root().$this->war->opponentlogo.'" alt="' . $this->war->opponent . '" style="height:24px;width:24px;"/><br />'; 	
		}
		else
		{
			$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $this->war->opponent . '" style="height:24px;width:24px;"/><br />'; 		
		}
		$html[] = $this->war->opponent;
		$html[] = '		</td>';	
		$html[] = '	</tr>';
		$html[] = '	<tr>';
		$html[] = '		<td id="wartemplate_left" class="wartemplate_players">';
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
		$html[] = '		<td id="wartemplate_middle">';
		$html[] = '		</td>';
		$html[] = '		<td id="wartemplate_right" class="wartemplate_players">';
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
		
		$html[] = '<br />';		
		
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
		
		$html[] = '<br />';	
		
		if (count($this->war->rounds) > 0)
		{
			$html[] = '<table id="wartemplate_rounds">';
			$html[] = '	<tr>';		
			$html[] = '		<th colspan="3">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_WAR_ROUNDS');
			$html[] = '		</th>';
			$html[] = '	</tr>';
			
			foreach ($this->war->rounds as $round)
			{
				$html[] = '<tr>';	
				$html[] = '<td class="wartemplate_rounds_map">';
				
				if ($round->mapimage != '')
				{
					$html[] = '<img src="'.JURI::root().$round->mapimage.'" alt="' . $round->map . '" title="' . $round->map . '" style="height:100px"/>'; 	
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/nomapimage.jpg" alt="' . $round->map . '" style="height:100px"/>'; 		
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
					
					$html[] = '<a href="'.$imagepath.'" rel="lightbox-screens" title="'. $round->map . ' - ' . $round->score . ' : ' . $round->score_opponent . '">';
					$html[] = '<img src="'.JURI::root().$round->screenshot.'" alt="' . $imagepath . '" title="' . $round->screenshot . '" style="height:100px"/>'; 	
					$html[] = '</a>';
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="" title=""  style="height:100px"/>'; 		
				}	
				
				$html[] = '</td>';
				$html[] = '</tr>';
			}
			$html[] = '</table>';
			
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
