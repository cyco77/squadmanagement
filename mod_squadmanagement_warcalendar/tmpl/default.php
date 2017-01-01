<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

$document = JFactory::getDocument();
$cssHTML = JURI::base().'modules/mod_squadmanagement_warcalendar/style/style.css';
$document->addStyleSheet($cssHTML);

JHTML::_('behavior.tooltip');

$html = array();

$html[] = RenderMonth($year,$month,$wars);

echo implode("\n", $html); 	

function RenderMonth($year, $month, $wars)
{	
	$html = array();

	// find out the number of days in the month
	$numdaysinmonth = cal_days_in_month( CAL_GREGORIAN, $month, $year );   
	
	// create a calendar object
	$jd = cal_to_jd( CAL_GREGORIAN, $month,date( 1 ),  $year );    

	// get the start day as an int (0 = Sunday, 1 = Monday, etc)
	$startday = jddayofweek( $jd , 0 ) - 1;		
	if ($startday == -1) {$startday = 6; }    

	// get the month as a name
	$monthname = JText::_( jdmonthname( $jd, 1 ) );  
	$html[] = '<div class="mod_squadmanagement_warcalendar_calendar">';
	$html[] = '<center>';
	$html[] = '<table class="mod_squadmanagement_warcalendar_calendar_table">';
	$html[] = '	<tr style="border: 0;">';
	$html[] = '		<td style="border: 0;">';
	$html[] = '			<form method="post" action="'.str_replace('&','&amp;',JURI::getInstance()->toString()).'">';
	$html[] = '				<input type="hidden" name="squadmanagementmodulenewmonth" value="'.($month == 1 ? 12 : $month - 1).'" />';
	$html[] = '				<input type="hidden" name="squadmanagementmodulenewyear" value="'.($month == 1 ? $year - 1 : $year).'" />';
	$html[] = '				<button type="submit" style="padding-left: 5px; padding-right: 5px;">&lt;</button>';
	$html[] = '			</form>';
	$html[] = '		</td>';
	$html[] = '		<td style="border: 0;" colspan="5"><div align="center"><strong class="mod_squadmanagement_warcalendar_calendar_header">' . $monthname." ".$year . '</strong></div></td>';
	$html[] = '		<td style="border: 0;">';
	$html[] = '			<form method="post" action="'.str_replace('&','&amp;',JURI::getInstance()->toString()).'">';
	$html[] = '				<input type="hidden" name="squadmanagementmodulenewmonth" value="'.($month == 12 ? 1 : $month + 1).'" />';
	$html[] = '				<input type="hidden" name="squadmanagementmodulenewyear" value="'.($month == 12 ? $year + 1 : $year).'" />';
	$html[] = '				<button type="submit" style="padding-left: 5px; padding-right: 5px;">&gt;</button>';
	$html[] = '			</form>';
	$html[] = '		</td>';		
	$html[] = '	</tr>';
	$html[] = '	<tr style="border: 0;">';
	$html[] = '		<td class="mod_squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Mon' ) . '</td>';
	$html[] = '		<td class="mod_squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Tue' ) . '</td>';
	$html[] = '		<td class="mod_squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Wed' ) . '</td>';
	$html[] = '		<td class="mod_squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Thu' ) . '</td>';
	$html[] = '		<td class="mod_squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Fri' ) . '</td>';
	$html[] = '		<td class="mod_squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Sat' ) . '</td>';
	$html[] = '		<td class="mod_squadmanagement_warcalendar_calendar_daysofweek">' . JText::_( 'Sun' ) . '</td>';
	$html[] = '	</tr>';
	$html[] = '	<tr>';

	// put render empty cells
	$emptycells = 0;   
	for( $counter = 0; $counter <  $startday; $counter ++ ) 
	{
		$html[] = '<td class="mod_squadmanagement_warcalendar_calendar_cell">-</td>';
		$emptycells ++;
	}
	
	// renders the days
	$rowcellcounter = $emptycells;
	$numinrow = 7;
	$closingtrneeded = false;
	
	for( $counter = 1; $counter <= $numdaysinmonth; $counter ++ ) 
	{
		$rowcellcounter ++;
		
		$span = '<span>'.$counter.'</span>';
		$resultclass = 'mod_squadmanagement_warcalendar_result_nothing';
		
		if ($wars)
		{
			$actualwars = getWars($counter,$month,$year,$wars);			
			if (count($actualwars) > 0)
			{
				$resultclass = 'mod_squadmanagement_warcalendar_result_challenged';
				
				if ($actualwars[0]->state == 1)
				{
					if ($actualwars[0]->score == $actualwars[0]->scoreopponent)
					{
						$resultclass = 'mod_squadmanagement_warcalendar_result_draw';
					}				
					if ($actualwars[0]->score > $actualwars[0]->scoreopponent)
					{
						$resultclass = 'mod_squadmanagement_warcalendar_result_win';
					}
					if ($actualwars[0]->score < $actualwars[0]->scoreopponent)
					{
						$resultclass = 'mod_squadmanagement_warcalendar_result_lost';
					}	
				}			
				
				$link = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&id='. $actualwars[0]->id );
				
				$tooltipbody = 'Liga: ' . $actualwars[0]->league.'<br />';
				if ($actualwars[0]->state == 1)
				{
					$tooltipbody .= 'Ergebnis: ' . $actualwars[0]->score .' : '. $actualwars[0]->scoreopponent;
				}
				
				$span = '<a href="'.$link.'"><span class="hasTip" title="'.$actualwars[0]->squad . ' vs. ' . $actualwars[0]->opponent.'::'.$tooltipbody.'">'.$counter.'</span></a>';
			}
		}
		
		$html[] = '<td class="mod_squadmanagement_warcalendar_calendar_cell '.$resultclass.'" >'.$span.'</td>';
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
			$html[] = '<td class="mod_squadmanagement_warcalendar_calendar_cell">-</td>';
			$emptycells ++;
		}   	
	}
	if ($closingtrneeded) { $html[] = '</tr>'; }
	$html[] = '</table>';
	$html[] = '</center>';
	$html[] = '</div>';
	
	return implode("\n", $html); 			
}		

function getWars($day,$month,$year,$wars)
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

?>

