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

class CalendarHelper
{
	static function getLocalizedDate($date = 'now', $format_string = '%Y-%M-%D')
	{
		jimport('joomla.utilities.date');
		$jdate = new JDate($date);
		return $jdate->format($format_string,true);
	}
	
	static function getCalDaysInMonth($month, $year) 
	{ 
		return date('t', mktime(0, 0, 0, $month, 1, $year)); 
	}
	
	static function renderMonth($year, $month, $wars, $appointments, $wartemplate)
	{	
		$html = array();

		// find out the number of days in the month
		$numdaysinmonth = self::getCalDaysInMonth( $month, $year );   
		
		$startday = date("N", mktime(0, 0, 0, $month, 1, $year))-1;
		if ($startday == -1) 
		{
			$startday = 1; 
		}

		// get the month as a name
		$monthname = self::getLocalizedDate(date('01-'.$month.'-'.$year),'F');
		$html[] = '<div class="squadmanagement_warcalendar_calendar">';
		$html[] = '<table class="squadmanagement_warcalendar_calendar_table">';
		$html[] = '	<tr>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_header">';
		$html[] = '			<form method="post" action="'.str_replace('&','&amp;',JURI::getInstance()->toString()).'">';
		$html[] = '				<input type="hidden" name="squadmanagementagendanewmonth" value="'.($month == 1 ? 12 : $month - 1).'" />';
		$html[] = '				<input type="hidden" name="squadmanagementagendanewyear" value="'.($month == 1 ? $year - 1 : $year).'" />';
		$html[] = '				<button type="submit" style="padding-left: 5px; padding-right: 5px;">&lt;</button>';
		$html[] = '			</form>';
		$html[] = '		</td>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_header" colspan="5"><div align="center">' . $monthname." ".$year . '</div></td>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_header">';
		$html[] = '			<form method="post" action="'.str_replace('&','&amp;',JURI::getInstance()->toString()).'">';
		$html[] = '				<input type="hidden" name="squadmanagementagendanewmonth" value="'.($month == 12 ? 1 : $month + 1).'" />';
		$html[] = '				<input type="hidden" name="squadmanagementagendanewyear" value="'.($month == 12 ? $year + 1 : $year).'" />';
		$html[] = '				<button type="submit" style="padding-left: 5px; padding-right: 5px;">&gt;</button>';
		$html[] = '			</form>';
		$html[] = '		</td>';		
		$html[] = '	</tr>';
		$html[] = '	<tr>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Monday' ) . '</td>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Tuesday' ) . '</td>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Wednesday' ) . '</td>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Thursday' ) . '</td>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Friday' ) . '</td>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Saturday' ) . '</td>';
		$html[] = '		<td class="squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Sunday' ) . '</td>';
		$html[] = '	</tr>';
		$html[] = '	<tr>';

		// put render empty cells
		$emptycells = 0;   
		for( $counter = 0; $counter <  $startday; $counter ++ ) 
		{
			$html[] = '<td class="squadmanagement_warcalendar_day_cell"></td>';
			$emptycells ++;
		}
		
		// renders the days
		$rowcellcounter = $emptycells;
		$numinrow = 7;
		$closingtrneeded = false;	
		
		for( $counter = 1; $counter <= $numdaysinmonth; $counter ++ ) 
		{
			$rowcellcounter ++;
			
			$innercontent = '<span>'.$counter.'</span>';
			$resultclass = 'squadmanagement_warcalendar_result_nothing';
			
			if ($wars || $appointments)
			{
				$actualwars = self::getWars($counter,$month,$year,$wars);	
				$actualappointments = self::getappointments($counter,$month,$year,$appointments);			
				
				$innercontent = self::getInnerCalendarContent($counter,$month,$year,$actualwars,$wartemplate,$actualappointments);			
			}
			
			$html[] = '<td class="squadmanagement_warcalendar_day_cell '.$resultclass.'" >'.$innercontent.'</td>';
			if( $rowcellcounter % $numinrow == 0 ) 
			{
				$html[] = '</tr>';
				if( $counter < $numdaysinmonth ) 
				{
					$html[] = '<tr>';
					$closingtrneeded = true;
				}
				else
				{
					$closingtrneeded = false;	
				}
				
				$rowcellcounter = 0;
			}
		}

		// clean up
		$numcellsleft = $numinrow - $rowcellcounter; 
		if( $numcellsleft != $numinrow ) 
		{
			for( $counter = 0; $counter < $numcellsleft; $counter ++ ) 
			{
				$html[] = '<td class="squadmanagement_warcalendar_day_cell"></td>';
				$emptycells ++;
			}   	
		}
		if ($closingtrneeded) { $html[] = '</tr>'; }
		$html[] = '</table>';
		$html[] = '</div>';
		$html[] = '<div style="clear:both;"></div>';
		
		return implode("\n", $html); 			
	}		
	
	static function getInnerCalendarContent($day,$month,$year, $wars,$wartemplate,$appointments)
	{	
		$html = array();
		
		$date1 = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));	
		$today = date('Y-m-d');			
		
		if ($date1 == $today)
		{
			$html[] = '<div class="squadmanagement_warcalendar_day_current"></div>';			
		}		
		
		$html[] = '<div class="squadmanagement_warcalendar_day_number">'.$day.'</div>';
		
		foreach ($wars as $war)
		{
			$resultclass = 'squadmanagement_warcalendar_result_challenged';
			
			if ($war->state == 1)
			{
				if ($war->score == $war->scoreopponent)
				{
					$resultclass = 'squadmanagement_warcalendar_result_draw';
				}				
				if ($war->score > $war->scoreopponent)
				{
					$resultclass = 'squadmanagement_warcalendar_result_win';
				}
				if ($war->score < $war->scoreopponent)
				{
					$resultclass = 'squadmanagement_warcalendar_result_lost';
				}	
			}			
			
			$link = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&id='. $war->id.'&amp;wartemplate='.$wartemplate );
			
			$tooltipbody = 'Liga: ' . $war->league.'<br />';
			if ($war->state == 1)
			{
				$tooltipbody .= 'Ergebnis: ' . $war->score .' : '. $war->scoreopponent;
			}
			
			$html[] = '<div class="squadmanagement_warcalendar_war">';
			$html[] = '	<a href="'.$link.'">';
			$html[] = '		<span class="hasTip" title="'.$war->squad . ' vs. ' . $war->opponent.'::'.$tooltipbody.'">';
			
			$html[] = '			<table>';
			$html[] = '				<tr>';
			$html[] = '					<td class="squadmanagement_warcalendar_war_result '.$resultclass.'">';
			$html[] = '					</td>';
			$html[] = '					<td>';
			if ($war->opponentlogo != '')
			{
				$html[] = '						<img src="'.JURI::root().$war->opponentlogo.'" alt="' . $war->squad . '" style="height:20px;width:20px;max-width:none;" />'; 	
			}
			else
			{
				$html[] = '						<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $war->squad . '" style="height:20px;width:20px;max-width:none;" />'; 		
			}
			$html[] = '					</td>';	
			
			$html[] = '					<td>';
			$html[] = $war->opponent;
			$html[] = '					</td>';				
			
			$html[] = '				</tr>';
			$html[] = '			</table>';
			$html[] ='		</span>';
			$html[] ='	</a>';
			$html[] = '</div>';			
		}
		
		foreach ($appointments as $appointment)
		{
			
			$resultclass = 'squadmanagement_warcalendar_appointment_'.$appointment->type;					
			
			$link = JRoute::_( 'index.php?option=com_squadmanagement&view=appointment&tmpl=component&id='. $appointment->id );
			
			$tooltipbody = 'Squad: ' . $appointment->squadname.'<br />';
			
			$html[] = '<div class="squadmanagement_warcalendar_war">';
			$html[] = '	<a href="'.$link.'" class="modal" style="position: relative" rel="{handler: \'iframe\', size: {x: 400, y: 400}}">';
			
			$tooltipbody = $appointment->subject.' - ' . JHtml::_('date', $appointment->startdatetime,JText::_('DATE_FORMAT_LC2'));
			
			$html[] = '		<span class="hasTip" title="'.$appointment->squadname.'::'.$tooltipbody.'">';
			
			$html[] = '			<table>';
			$html[] = '				<tr>';
			$html[] = '					<td class="squadmanagement_warcalendar_war_result '.$resultclass.'">';
			$html[] = '					</td>';
			$html[] = '					<td>';
			if ($appointment->squadimage != '')
			{
				$html[] = '						<img src="'.JURI::root().$appointment->squadimage.'" alt="' . $appointment->squadname . '" style="height:20px;width:20px;max-width:none;" />'; 	
			}
			else
			{
				$html[] = '						<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $appointment->squadname . '" style="height:20px;width:20px;max-width:none;" />'; 		
			}
			$html[] = '					</td>';	
			
			$html[] = '					<td>';
			$html[] = $appointment->subject;
			$html[] = '					</td>';				
			
			$html[] = '				</tr>';
			$html[] = '			</table>';
			$html[] ='		</span>';
			$html[] ='	</a>';
			$html[] = '</div>';			
		}
		
		return implode("\n", $html); 		
	}
	
	static function getWars($day,$month,$year,$wars)
	{
		$result = array();
		
		foreach($wars as $war)
		{		
			$date1 = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
			$date2 = JHtml::_('date', $war->wardatetime, JText::_('Y-m-d'));
			
			if ($date1 == $date2)
			{
				$result[] = $war;	
			}
		}			
		
		return $result;
	}	
	
	static function getAppointments($day,$month,$year,$appointments)
	{
		$result = array();
		
		foreach($appointments as $appointment)
		{		
			$date1 = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
			$date2 = JHtml::_('date', $appointment->startdatetime, JText::_('Y-m-d'));
			
			if ($date1 == $date2)
			{
				$result[] = $appointment;	
			}
		}			
		
		return $result;
	}	
	
	public static function renderLegend($list)
	{
		$html = array();
		
		$html[] = '<div class="squadmanagement_warcalendar_legend">';
		$html[] = '	<ul>';
		$html[] = '		<li><div class="squadmanagement_warcalendar_result_challenged" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_CHALLENGED', 'Scheduled Game' ).'</li>';
		$html[] = '		<li><div class="squadmanagement_warcalendar_result_win" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_WIN', 'Win' ).'</li>';
		$html[] = '		<li><div class="squadmanagement_warcalendar_result_draw" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_DRAW', 'Draw' ).'</li>';
		$html[] = '		<li><div class="squadmanagement_warcalendar_result_lost" style="width: 7px;height:20px;"></div>'.JText::_( 'COM_SQUADMANAGEMENT_WARSTATE_PLAYED_LOST', 'Lost' ).'</li>';
		$html[] = '	</ul>';		
		$html[] = '</div>';
		$html[] = '<div class="squadmanagement_warcalendar_legend">';
		$html[] = '	<ul>';
		
		$counter = 0;
		
		foreach ($list as $item)
		{
			$html[] = '		<li><div class="squadmanagement_warcalendar_appointment_'.$counter.'" style="width: 7px;height:20px;"></div>'.trim($item).'</li>';
			
			if ($counter < 9) 
			{
				$counter++;
			}
		}		

		$html[] = '	</ul>';		
		$html[] = '</div>';
		
		return implode("\n", $html); 	
	}
}
