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

$html[] = '<table id="usersuggestions_table">';
$html[] = '	<tr>';
$html[] = '		<th>';
$html[] = '			Name';
$html[] = '		</th>';
$html[] = '		<th style="text-align:left;">';
$html[] = '			Email';
$html[] = '		</th>';
$html[] = '	</tr>';

$cnt = 0;

foreach	($this->users as $user)
{		
	if (!isUserInSquad($user,$this->squad))
	{			
		$html[] = '	<tr class="usersuggestions_row" onClick="assignsquadmember(\''.$user->name.'\',\''.$user->id.'\'); return false;">';
		$html[] = '		<td class="usersuggestions_column_username">';
		$html[] = $user->name;
		$html[] = '		</td>';
		$html[] = '		<td class="usersuggestions_column_email">';
		$html[] = $user->email;
		$html[] = '		</td>';
		$html[] = '	</tr>';
		
		$cnt++;	
	}
}

if ($cnt == 0)
{
	$html[] = '<tr><td colspan="3">0 Users found</td></tr>';	
}

$html[] = '</table>';

echo json_encode(implode("\n", $html));  

function isUserInSquad($user,$squad)
{
	foreach ($squad->members as $member)
	{
		if ($user->id == $member->userid)
		{
			return true;	
		}	
	}	
	
	return false;
}

?>