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

abstract class baseTemplate
{
	public abstract function renderTemplate();
	
	function getLastSquadMemberOnline($squadmember)
	{
		if ($squadmember != null && $squadmember->guest === '0')
		{
			return 'Online';	
		}
		
		if ($squadmember->lastvisitdate == '0000-00-00 00:00:00')
		{
			return JText::_('COM_SQUADMANAGEMENT_SQUAD_MEMBER_ONLINE').': -';	
		}
		
		$lastOnline = JHtml::_('date', $squadmember->lastvisitdate, JText::_('DATE_FORMAT_LC2'));
		return '<span>'.JText::_('COM_SQUADMANAGEMENT_SQUAD_MEMBER_ONLINE').': '. $lastOnline .'</span>';
	}	
	
	function getSquadMemberRole($squadmember)
	{
		if ($squadmember->role == '')
		{
			return JText::_("COM_SQUADMANAGEMENT_SQUAD_MEMBER_ROLE").': -';	
		}
		
		return JText::_("COM_SQUADMANAGEMENT_SQUAD_MEMBER_ROLE").': '.$squadmember->role;	
	}
	
	function renderField($field, $member, $withcaption = true)
	{
		$fieldname = $field->fieldname;
		$value = $member->$fieldname;
		
		$caption = $withcaption ? $field->name . ': ' : '';
		
		if ($value == '')
		{
			return $caption . '-';
		}
		
		switch ($field->fieldtype)
		{
			case 'icq':
				$output = '<div style="display: table;">';
				$output .= '	<div style="float:left;display: table-cell;">';
				$output .= '		<img src="http://web.icq.com/whitepages/online?icq='.$value.'&amp;img=5" alt="'.$value.'" />';
				$output .= '	</div>';
				$output .= '	<div style="display: table-cell;vertical-align:middle;">';
				$output .= $value;
				$output .= '	</div>';
				$output .= '</div>';
				
				return $output;
				break;
			case 'skype':
				$output = '<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script><a href="skype:'.$value.'?call"><img src="http://mystatus.skype.com/smallclassic/'.$value.'" style="border: none;" width="114" height="20" alt="Skype Status" /></a>';
				
				return $output;
				break;
			case 'date':			
				if ($value == '0000-00-00')
				{
					return $caption . '-';
				}
				
				return $caption. date_format(date_create($value), JText::_('COM_SQUADMANAGEMENT_DATE'));				
				break;
			case 'number':
				return $caption. $value;
				break;					
			default:
				return $caption. $value;
		}				
	}
}

?>