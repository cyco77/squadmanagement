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

$output = '<table class="usersuggestions_table">';
$output .= '<tr>';
$output .= '<th>';
$output .= JText::_('COM_SQUADMANAGEMENT_USERLOOKUP_NAME');
$output .= '</th>';
$output .= '<th style="text-align:left;">';
$output .= JText::_('COM_SQUADMANAGEMENT_USERLOOKUP_EMAIL');
$output .= '</th>';

if (count($this->users) == 0)
{
	$output .= '<tr><td colspan="3">0 Users found</td></tr>';	
}
else
{
	foreach	($this->users as $user)
	{		
		$output .= '<tr onclick="assignuserid(\''.$user->name.'\',\''.$user->id.'\')">';
		$output .= '<td class="usersuggestions_column_username">';
		$output .= $user->name;
		$output .= '</td>';
		$output .= '<td class="usersuggestions_column_email">';
		$output .= $user->email;
		$output .= '</td>';
		$output .= '</tr>';
	}
}

$output .= '</tr>';
$output .= '</table>';

echo $output;
