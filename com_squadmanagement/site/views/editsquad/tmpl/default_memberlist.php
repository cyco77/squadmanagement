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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'imagehelper.php');

$html = array();

$html[] = '<table id="squadmembers">';
$html[] = '	<thead>';
$html[] = '		<tr>';
$html[] = '			<th>';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Username';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Displayname';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Role';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Ordering';			
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				State';			
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '			</th>';
$html[] = '		</tr>';
$html[] = '	</thead>';

$html[] = '	<tbody>';
foreach	($this->squad->members as $i => $member)
{
	$html[] = ' 	<tr id="squadmemberrow_'. $member->id .'">';
	$html[] = ' 		<td align="center" valign="middle" style="width:50px;">';
	
	$image = IntegrationHelper::getFullAvatarImagePath($member->avatar);
	$width = ImageHelper::getImageWidth($image,50);
	
	$html[] = ' 			<img src="'.$image.'" alt="' . $member->name . '" style="height:50px;width:'.$width.'px;max-width: none;"/>'; 
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="40%">';			
	$html[] = ' 			<span>';
	$html[] = ' 				<a href="'.JRoute::_('index.php?option=com_squadmanagement&view=squadmember&id=' . $member->userid) . '">';
	$html[] = $member->name;
	$html[] = ' 				</a>';
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="40%">';
	$html[] = ' 			<span>';
	$html[] = $member->displayname;
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="40%">';
	$html[] = ' 			<span>';
	$html[] = '					<input size="20" name="jform[squadmember_role_'.$member->id.']" id="jform_squadmember_role_'.$member->id.'" type="text" value="'.$member->role.'"/>';
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="20">';
	$html[] = ' 			<span>';
	$html[] = '					<input size="2" name="jform[squadmember_ordering_'.$member->id.']" id="jform_squadmember_ordering_'.$member->id.'" type="text" value="'.$member->ordering.'"/>';
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="20">';
	$html[] = ' 			<span>';
	
	$html[] = '					<select id="jform_squadmember_memberstate_'.$member->id.'" name="jform[squadmember_memberstate_'.$member->id.']" class="inputbox" size="1" required="" aria-required="true">';
	$html[] = '						<option value="0"'. ($member->memberstate == 0 ? ' selected="selected" ' : '').'>'.JText::_('ALL_SQUADMANAGEMENT_MEMBER_STATE_JOINREQUEST').'</option>';
	$html[] = '						<option value="1"'. ($member->memberstate == 1 ? ' selected="selected" ' : '').'>'.JText::_('ALL_SQUADMANAGEMENT_MEMBER_STATE_TRIAL').'</option>';
	$html[] = '						<option value="2"'. ($member->memberstate == 2 ? ' selected="selected" ' : '').'>'.JText::_('ALL_SQUADMANAGEMENT_MEMBER_STATE_FULLMEMBER').'</option>';
	$html[] = '					</select>';
	
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';	
	$html[] = ' 		<td>';
	$html[] = ' 			<a href="#" onClick="removeSquadMember(' . $member->id . ','. $this->squad->id .');return false;">';
	$html[] = ' 				<img style="max-width: none;" src="'.JURI::base().'components/com_squadmanagement/images/user-delete.png" alt="Delete"/>';
	$html[] = ' 			</a>';
	$html[] = ' 		</td>';
	$html[] = ' 	</tr>';
}

$html[] = '	</tbody>';
$html[] = '</table>';

echo json_encode(implode("\n", $html));  

?>