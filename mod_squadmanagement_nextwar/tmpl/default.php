<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

$html = array();

$html[] = 'SquadManagement! Wars';

if (isset($item))
{
	$link = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&amp;id='. $item->id );
	
	$html[] = '<table>';
	$html[] = '<tr>';
	$html[] = '<td class="mod_squadmanagement_wars_logo" rowspan="2">';
	if ($item->squadlogo != '')
	{
		$html[] = '<img src="'.JURI::root().$item->squadlogo.'" alt="' . $item->squad . '" title="' . $item->squad . '" style="height:20px;width:20px;"/>'; 	
	}
	else
	{
		$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->squad . '" title="' . $item->squad . '" style="height:20px;width:20px;"/>'; 		
	}
	$html[] = '</td>';
	
	$html[] = '<td class="mod_squadmanagement_wars_opponent">';
	$html[] = '<a href="'.$link.'">';
	$html[] = ' vs. '.$item->opponent;
	$html[] = '</a>';
	$html[] = '</td>';
	
	$html[] = '<td class="mod_squadmanagement_wars_datetime" rowspan="2">';
	$html[] = JHtml::_('date', $item->wardatetime, JText::_('MOD_SQUADMANAGEMENT_NEXTWAR_STATE_DATETIME'));
	$html[] = '</td>';		
	$html[] = '</tr>';
	$html[] = '<tr>';
	$html[] = '<td class="mod_squadmanagement_wars_league">';
	$html[] = $item->league;
	$html[] = '</td>';
	$html[] = '</tr>';

	$html[] = '</table>';	
}
else
{
	$html[] = JText::_('NO_UPCOMING_WAR');
}


echo implode("\n", $html); 	
?>

