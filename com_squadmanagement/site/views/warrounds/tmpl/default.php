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

$html = array();

$html[] = '<table class="table table-striped" id="articleList">';
$html[] = '		<thead>';
$html[] = '			<tr>';
$html[] = '				<th style="text-align:left">';
$html[] = JText::_('COM_SQUADMANAGEMENT_WARROUND_HEADING_MAPIMAGE');
$html[] = '             </th>';
$html[] = '				<th style="text-align:left" class="nowrap hidden-phone">';
$html[] =  JText::_('COM_SQUADMANAGEMENT_WARROUND_HEADING_MAP');
$html[] = '				</th>';
$html[] = '				<th style="text-align:left">';
$html[] =  JText::_('COM_SQUADMANAGEMENT_WARROUND_HEADING_SCORE');
$html[] = '				</th>';
$html[] = '				<th style="text-align:left">';
$html[] =  JText::_('COM_SQUADMANAGEMENT_WARROUND_HEADING_SCREENSHOT');
$html[] = '				</th>';
$html[] = '				<th></th>';
$html[] = '			</tr>';
$html[] = '		</thead>';
$html[] = '		<tbody>';
foreach($this->items as $i => $item)
{
	$pageNav = $this->pagination;
	$html[] = '			<tr class="row'. $i % 2 .'">';
	$html[] = '				<td>';
	if ($item->mapimage != '')
	{
		$html[] = '<img src="'.JURI::root().$item->mapimage.'" alt="'.$item->map.'" title="'.$item->map.'" style="max-height:100px; max-width: 200px;" />';
	}
	else
	{
		$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/nomapimage.jpg" alt="' . $item->screenshot . '"  style="max-height:100px; max-width: 200px;"/>'; 		
	}
	$html[] = '				</td>';		
	$html[] = '				<td class="nowrap hidden-phone">';
	$html[] = $item->map != '' ? $item->map : '-';
	$html[] = '				</td>';
	$html[] = '				<td>';
	$html[] = $item->score.' : '.$item->score_opponent;
	$html[] = '				</td>';
	$html[] = '				<td>';
	if ($item->screenshot != '')
	{	
		$parts = pathinfo(JURI::root().$item->screenshot);		
		$imagepath = $parts['dirname'].'/thumbs/'.$parts['basename'];
		
		$html[] = '<a href="'.JURI::root().$item->screenshot.'" rel="lightbox-screens" title="'. $item->map . ' - ' . $item->score . ' : ' . $item->score_opponent . '">';
		$html[] = '<img src="'.$imagepath.'" alt="' . $imagepath . '" title="' . $item->screenshot . '" style="max-height:100px; max-width: 200px;"/>'; 	
		$html[] = '</a>';
	}
	else
	{
		$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->screenshot . '" title="' . $item->screenshot . '" style="max-height:100px; max-width: 200px;"/>'; 		
	}	
	$html[] = '				</td>';
	$html[] = '				<td>';
	$html[] = '				<input type="button" class="button" name="Remove" value="'.JText::_( 'COM_SQUADMANAGEMENT_WARROUND_DELETE' ).'" onclick="removeRound('.$item->id.')" />';
	$html[] = '				</td>';
	$html[] = '			</tr>';
}
$html[] = '		</tbody>';
$html[] = '	</table>';

echo json_encode(implode("\n", $html)); 