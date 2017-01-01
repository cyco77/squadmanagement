<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

$html = array();

if (count($warlist) == 0)
{
	$html[] = JText::_('MOD_SQUADMANAGEMENT_WARS_NO_WARS');	
}
else
{
	$html[] = '<table class="mod_squadmanagement_wars_table">';
		
	foreach($warlist as $i => $item)
	{
		$link = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&amp;id='. $item->id );
		
		$html[] = '<tr>';
		$html[] = '<td class="mod_squadmanagement_wars_logo" rowspan="2">';
		if ($item->squadlogo != '')
		{
			$html[] = '<img src="'.JURI::root().$item->squadlogo.'" alt="' . $item->squad . '" title="' . $item->squad . '" height="20" width="20"/>'; 	
		}
		else
		{
			$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->squad . '" title="' . $item->squad . '" height="20" width="20"/>'; 		
		}
		$html[] = '</td>';
			
		$html[] = '<td class="mod_squadmanagement_wars_opponent">';
		$html[] = '<a href="'.$link.'">';
		$html[] = ' vs. '.$item->opponent;
		$html[] = '</a>';
		$html[] = '</td>';
		
		$html[] = '<td class="mod_squadmanagement_wars_datetime" rowspan="2">';
		$html[] = JHtml::_('date', $item->wardatetime, JText::_('MOD_SQUADMANAGEMENT_WARS_STATE_DATETIME'));
		$html[] = '</td>';		
		$html[] = '</tr>';
		$html[] = '<tr>';
		$html[] = '<td class="mod_squadmanagement_wars_league">';
		$html[] = $item->league;
		$html[] = '</td>';
		$html[] = '</tr>';
	}		
	
	$html[] = '</table>';
}




echo implode("\n", $html); 	
?>

