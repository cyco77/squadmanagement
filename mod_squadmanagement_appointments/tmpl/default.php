<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal'); 

$html = array();

if (count($list) == 0)
{
	$html[] = JText::_('MOD_SQUADMANAGEMENT_APPOINTMENTS_NO_APPOINTMENTS');	
}
else
{
	$html[] = '<div class="mod_squadmanagement_appointments">';
		
	foreach($list as $i => $item)
	{
		$html[] = '<div class="mod_squadmanagement_appointment">';
		
		$link = JRoute::_( 'index.php?option=com_squadmanagement&view=appointment&tmpl=component&id='. $item->id );
		
		$html[] = '	<a href="'.$link.'" class="modal" style="position: relative" rel="{handler: \'iframe\', size: {x: 400, y: 400}}">';
			
		if ($item->squadlogo != '')
		{
			$html[] = '<img src="'.JURI::root().$item->squadlogo.'" alt="' . $item->squadname . '" title="' . $item->squadname . '" style="height: 20px; width: 20px; max-width: none" />'; 	
		}
		else
		{
			$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->squadname . '" style="height: 20px; width: 20px; max-width: none" />'; 		
		}
		$html[] = JHtml::_('date', $item->startdatetime, JText::_(JText::_('MOD_SQUADMANAGEMENT_APPOINTMENTS_DATETIME')));
		$html[] = ' - ';
		$html[] = $item->subject;
		$html[] = '</a>';
		$html[] = '</div>';
	}	
	
	$html[] = '</div>';
}

echo implode("\n", $html); 	
?>

