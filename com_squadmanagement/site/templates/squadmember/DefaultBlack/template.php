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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basesquadmembertemplate.php');
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';

class defaultblacksquadmembertemplate extends basesquadmembertemplate
{
	public function renderTemplate()
	{
		JHTML::_('behavior.modal');
		
		$html = array();		
		
		$doc = JFactory::getDocument();

		$cssHTML = JURI::base().'components/com_squadmanagement/templates/squadmember/DefaultBlack/style.css';
		$doc->addStyleSheet($cssHTML);	
		
		$html[] = '<div class="squadmembertemplate_member">';
		$html[] = '	<div id="squadmembertemplate_member_image">';
		$html[] = '		<img src="'.IntegrationHelper::getFullAvatarImagePath($this->squadmember->avatar).'" alt="'.$this->squadmember->membername.'" title="'.$this->squadmember->membername.'" />';
				
		$html[] = '	</div>';			
		$html[] = '	<div id="squadmembertemplate_member_common">';
		$html[] = '		<div class="squadmembertemplate_member_name">';
		$html[] = $this->squadmember->membername;
		$html[] = '		</div>';

		$html[] = '		<div class="squadmembertemplate_member_commoninfo">';
		$html[] = '			<table>';

		foreach ($this->fieldlist as $field)
		{
			if ($field->tabid == -1)
			{
				$html[] = '<tr>';
				$html[] = '<td>';
				if ($field->icon != '')
				{
					$html[] = '<img src="'.JURI::root().$field->icon.'" alt="' . $field->name . '" style="height:20px;width:20px;max-width: none;"/>'; 		
				}
				$html[] = '</td>';
				$html[] = '<td class="squadmembertemplate_member_fieldheading">';
				$html[] = $field->name;
				$html[] = '</td>';
				$html[] = '<td class="squadmembertemplate_member_field">';
				
				$html[] = $this->renderField($field, $this->squadmember, false);
							
				$html[] = '</td>';
				$html[] = '</tr>';				
			}
		}

		$html[] = '			</table>';
		$html[] = '		</div>';		
		$html[] = '	</div>';		
		$html[] = '</div>';	
		
		$html[] = '	<div class="squadmembertemplate_member_additionalinfos">';
				
		$html[] = JHtml::_('tabs.start');
		
		foreach ($this->tablist as $tab)
		{
			$html[] = JHtml::_('tabs.panel',$tab->name,$tab->name);						
			
			$html[] = '<div class="squadmembertemplate_member_commoninfo">';
			$html[] = '<table>';
			
			foreach ($this->fieldlist as $field)
			{
				if ($field->tabid == $tab->id)
				{
					$html[] = '<tr>';
					$html[] = '<td>';
					if ($field->icon != '')
					{
						$html[] = '<img src="'.JURI::root().$field->icon.'" alt="' . $field->name . '" style="height:20px;width:20px;max-width: none;"/>'; 		
					}
					else
					{
						$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $field->name . '" style="height:20px;width:20px;max-width: none;"/>'; 		
					}
					$html[] = '</td>';
					$html[] = '<td class="squadmembertemplate_member_fieldheading">';
					$html[] = $field->name;
					$html[] = '</td>';
					$html[] = '<td class="squadmembertemplate_member_field">';
					
					$html[] = $this->renderField($field, $this->squadmember, false);
					
					$html[] = '</td>';
					$html[] = '</tr>';			
				}
			}	
			
			$html[] = '</table>';
			$html[] = '</div>';
		}
		
		
		
		if (isset($this->squadmember->steamdata))
		{
			$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_SQUADMEMBER_STEAMDATA'),JText::_('COM_SQUADMANAGEMENT_SQUADMEMBER_STEAMDATA'));
			
			$html[] = '<div class="steamdata">';						
			
			$steamdata = $this->squadmember->steamdata;
			
			$html[] = '<div class="steamplayer">';
			$html[] = '<div class="steamavatar">';
			$html[] = '<img src="'.$steamdata->avatarMedium.'" alt="'.$steamdata->steamID.'" />';
			$html[] = '</div>';
			$html[] = '<div class="steamid">';
			$html[] = '<a href="http://steamcommunity.com/id/'.$steamdata->customURL.'" target="_blank">'.$steamdata->steamID.'</a>';
			$html[] = '</div>';
			$html[] = '<div class="steamlocation">';
			$html[] = '<span>'.JText::_('COM_SQUADMANAGEMENT_STEAM_LOCATION').'</span>'. ($steamdata->location == '' ? '-' : $steamdata->location);
			$html[] = '</div>';
			$html[] = '<div class="steamstate">';
			$html[] = '<span>'.JText::_('COM_SQUADMANAGEMENT_STEAM_STATUS').'</span>'. $steamdata->onlineState;
			$html[] = '</div>';
			$html[] = '<div class="steammembersince">';
			$html[] = '<span>'.JText::_('COM_SQUADMANAGEMENT_STEAM_MEMBERSINCE').'</span>'.$steamdata->memberSince;
			$html[] = '</div>';
			$html[] = '</div>';
			
			$html[] = '<div class="steammostplayedgames">';
			
			$html[] = '<div class="steamrecentgameactivity">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_STEAM_RECENTGAMEACTIVITY');
			$html[] = '</div>';	
			
			foreach($steamdata->mostPlayedGames as $game)
			{
				$html[] = '<div class="steamgame">';
				$html[] = '<div class="steamgamelogo">';
				$html[] = '<img src="'. $game->gameLogoSmall.'" alt="'.$game->gameName.'" />';
				$html[] = '</div>';	
				$html[] = '<div class="steamgamename">';
				$html[] = '<a href="'.$game->gameLink.'" target="_blank">'.$game->gameName.'</a>';
				$html[] = '</div>';	
				$html[] = '<div class="steamhoursplayed">';
				$html[] = '<span>'.JText::_('COM_SQUADMANAGEMENT_STEAM_HOURSPLAYED').'</span>'. $game->hoursPlayed;
				$html[] = '</div>';	
				$html[] = '<div class="steamhoursonrecord">';
				$html[] = '<span>'.JText::_('COM_SQUADMANAGEMENT_STEAM_HOURSONRECORD').'</span>'. $game->hoursOnRecord;
				$html[] = '</div>';	
				$html[] = '</div>';	
			}
			
			$html[] = '</div>';
			
			$html[] = '<div class="steamgroups">';
			
			$html[] = '<div class="steamgroupdheader">';
			$html[] = JText::_('COM_SQUADMANAGEMENT_STEAM_GROUPSHEADER');
			$html[] = '</div>';	
			
			foreach($steamdata->groups as $group)
			{
				if ($group->groupName != '')
				{					
					$html[] = '<div class="steamgroup">';
					$html[] = '<div class="steamgrouplogo">';
					$html[] = '<img src="'. $group->avatarMedium.'" alt="'.$group->groupName.'" />';
					$html[] = '</div>';	
					$html[] = '<div class="steamgroupname">';
					$html[] = '<a href="http://steamcommunity.com/groups/'.$group->groupURL.'" target="_blank">'.$group->groupName.'</a>';
					$html[] = '</div>';	
					$html[] = '<div class="steamsteammembercount">';
					$html[] = '<span>'.JText::_('COM_SQUADMANAGEMENT_STEAM_MEMBERS').'</span>'. $group->memberCount;
					$html[] = '</div>';	
					$html[] = '<div class="steammembersonline">';
					$html[] = '<span>'.JText::_('COM_SQUADMANAGEMENT_STEAM_MEMBERSONLINE').'</span>'. $group->membersOnline;
					$html[] = '</div>';	
					$html[] = '<div class="steammembersingame">';
					$html[] = '<span>'.JText::_('COM_SQUADMANAGEMENT_STEAM_MEMBERSINGAME').'</span>'. $group->membersInGame;
					$html[] = '</div>';	
					$html[] = '</div>';	
				}
			}
			
			$html[] = '</div>';
			
			$html[] = '</div>';
		}
		
		if ($this->squadmember->description != '')
		{
			$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_SQUADMEMBER_DESCRIPTION'),JText::_('COM_SQUADMANAGEMENT_SQUADMEMBER_DESCRIPTION'));
						
			$html[] = '<div>';		
			$html[] = $this->squadmember->description;			
			$html[] = '</div>';
		}
		
		$html[] = JHtml::_('tabs.end'); 
		$html[] = '</div>';		
		
		echo implode("\n", $html); 		
	}	
}
