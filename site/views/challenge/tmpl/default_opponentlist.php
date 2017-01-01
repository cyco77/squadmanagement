<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squadmanagement!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2012 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://joomla.larshildebrandt.de
# Technical Support:  Forum - http://joomla.larshildebrandt.de/forum/index.html
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$html = array();

if (count($this->list) == 0)
{
	echo json_encode(implode("\n", $html)); 
	return;
} 

$html[] = '<table id="opponents">';
$html[] = '	<thead>';
$html[] = '		<tr>';
$html[] = '			<th>';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Name';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Url';
$html[] = '			</th>';
$html[] = '		</tr>';
$html[] = '	</thead>';

$html[] = '	<tbody>';
foreach	($this->list as $i => $opponent)
{
	$html[] = ' 	<tr class="opponents_row" onclick="assignopponent(\''.$opponent->name.'\',\''.$opponent->url.'\'); return false;">';
	$html[] = ' 		<td align="center" valign="middle">';
	if ($opponent->logo != '')
	{
		$html[] = '<img src="'.JURI::root().$opponent->logo.'" alt="' . $opponent->name . '" style="height:15px;width:15px;min-width:15px;"/>'; 	
	}
	else
	{
		$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $opponent->name . '" style="height:15px;width:15px;min-width:15px;"/>'; 		
	}	
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="50%">';			
	$html[] = ' 			<span>';
	$html[] = $opponent->name;
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="70%">';
	$html[] = ' 			<span>';
	$html[] = $opponent->url;
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 	</tr>';
}

$html[] = '	</tbody>';
$html[] = '</table>';

echo json_encode(implode("\n", $html));  

?>