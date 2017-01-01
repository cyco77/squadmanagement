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

// load tooltip behavior
JHtml::_('behavior.tooltip');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admin.css');
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/bankitemsmembers.css');

?>
<?php if (!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
	<?php else : ?>
<div id="j-main-container">
	<?php endif;?>		
<?php

$html = array();
$html[] = '<table class="table table-striped">';
$html[] = '		<thead>';
$html[] = '			<tr>';			
$html[] = '				<th width="1%">';
$html[] = '				</th>';
$html[] = '				<th style="text-align:left; width:20%">';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEMSMEMBERS_HEADING_MEMBER');
$html[] = '				</th>';		
$html[] = '				<th style="text-align:left;width:10%">';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEMSMEMBERS_HEADING_FROMDATE');
$html[] = '				</th>';		
$html[] = '				<th style="text-align:left;width:10%" >';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEMSMEMBERS_HEADING_DUES');
$html[] = '				</th>';	
$html[] = '				<th style="text-align:left;width:10%" >';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEMSMEMBERS_HEADING_PAYEDTO');
$html[] = '				</th>';	
//$html[] = '				<th width="1%">';
//$html[] = '				</th>';
$html[] = '				<th width="50%">';
$html[] = '				</th>';
$html[] = '			</tr>';	
$html[] = '		</thead>';
$html[] = '		<tbody>';

foreach($this->items as $i => $member)
{
	$html[] = '<tr class="row'. $i % 2 .'">';
	$html[] = ' <td >';	
$html[] = ' 	<img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" alt="' . $member->membername . '" style="height:35px;max-width: none;"/>'; 
	$html[] = ' </td>';	
	$html[] = ' <td >';
	$html[] = $member->membername;
	$html[] = ' </td>';
	$html[] = ' <td>';
	$html[] = $member->fromdate;
	$html[] = ' </td>';
	$html[] = ' <td>';
	$html[] = $member->dues;
	$html[] = ' </td>';
	$html[] = ' <td>';
	if (isset($member->payedto) && $member->payedto != '0000-00-00')
	{
		$html[] = $member->payedto;
	}
	$html[] = ' </td>';
	//$html[] = ' <td>';
	//$html[] = $this->min.' - '.date("Y-m-d").' - '.$this->max;	
	//$html[] = ' </td>';
	$html[] = ' <td>';

	if (isset($member->payedto) && $member->payedto != '0000-00-00')
	{
		$max = SquadManagementHelper::getDateDiff($this->min,$this->max);
		$day = SquadManagementHelper::getDateDiff($this->min,date("Y-m-d"));
		$current = SquadManagementHelper::getDateDiff($this->min,$member->payedto);	
		
		$html[] = '<table cellspacing="1" cellpadding="1" width="100%">';		
		$html[] = '<tr>';
		
		if  ($current == $max)
		{		
			$html[] = '<td style="background-color: #6dc44a;border: 1px solid #525252;width:' . (($day)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
			
			$html[] = '<td style="background-color: #309c05;border: 1px solid #525252;width:' . (($current-$day)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
		}	
		elseif ($current == 0)
		{
			$html[] = '<td style="background-color: #9c0505;border: 1px solid #525252;width:' . (($day-$current)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
			$html[] = '<td style="background-color: #ffffff;border: 1px solid #525252;width:' . (($max-$day-$current)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
		}	
		elseif  ($current < $day)
		{
			$html[] = '<td style="background-color: #6dc44a;border: 1px solid #525252;width:' . ($current/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
			$html[] = '<td style="background-color: #9c0505;border: 1px solid #525252;width:' . (($day-$current)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
			$html[] = '<td style="background-color: #ffffff;border: 1px solid #525252;width:' . (($max-$day-$current)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
		}	
		else
		{
			$html[] = '<td style="background-color: #6dc44a;border: 1px solid #525252;width:' . (($day)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
			
			$html[] = '<td style="background-color: #309c05;border: 1px solid #525252;width:' . (($current-$day)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
			$html[] = '<td style="background-color: #ffffff;border: 1px solid #525252;width:' . (($max-$current)/$max)*100 . '%;">';
			$html[] = '&nbsp;';
			$html[] = '</td>';
		}
		
		$html[] = '</tr>';
		$html[] = '</table>';
		
	}	
	$html[] = ' </td>';
	
	$html[] = '</tr>';
}

$html[] = '		</tbody>';
$html[] = '</table>';

echo implode("\n", $html);


?>



