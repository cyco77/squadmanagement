<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squad Management!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2014 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.larshildebrandt.de
# Technical Support:  Forum - http://www..larshildebrandt.de/forum/
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/appointment.css');	
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/admintoolbar.css');

$document->addScript( JURI::root().'/components/com_squadmanagement/script/editappointment.js' );

$html = array();

$html[] = '<h1>';
$html[] = $this->item->subject;

$user = JFactory::getUser();
$userid = $user->get('id');
if ($userid != 0 && $this->canAddAppointments)
{
	$html[] = '<div class="squadmanagement_admin_toolbar_item" style="float:right;" onclick="deleteappointment('.$this->item->id.');">';
	$html[] = '	<div class="squadmanagement_admin_toolbar_image">';		
	$html[] = '		<img src="'.JURI::root().'components/com_squadmanagement/images/user-delete.png" style="width: 16px; height: 16px;" alt="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_DELETE' ).'" title="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_DELETE' ).'" />';
	$html[] = '	</div>';
	$html[] = '</div>';

	$link = JRoute::_( 'index.php?option=com_squadmanagement&view=editappointment&id='.$this->item->id );
	
	$html[] = '<div class="squadmanagement_admin_toolbar_item" style="float:right;" onclick="window.parent.window.location.href = \''.$link.'\';" >';
	$html[] = '<div class="squadmanagement_admin_toolbar_image">';		
	$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/toolbox.png" style="width: 16px; height: 16px;" alt="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_EDIT' ).'" title="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_EDIT' ).'"/>';
	$html[] = '</div>';
	$html[] = '</div>';
}

if ($this->item->startdatetime > date("Y-m-d") && $userid != 0 && $this->isUserInSquad)
{
	if ($this->isUserInAppointment)
	{
		$html[] = '<div class="squadmanagement_admin_toolbar_item" style="float:right;" onclick="removeMemberFromAppointment('.$this->item->id.');">';
		$html[] = '	<div class="squadmanagement_admin_toolbar_image">';		
		$html[] = '		<img src="'.JURI::root().'components/com_squadmanagement/images/user-delete2.png" style="width: 16px; height: 16px;" alt="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_REMOVEFROM' ).'" title="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_REMOVEFROM' ).'" />';
		$html[] = '	</div>';
		$html[] = '</div>';
	}
	else
	{
		$html[] = '<div class="squadmanagement_admin_toolbar_item" style="float:right;" onclick="addMemberToAppointment('.$this->item->id.');">';
		$html[] = '	<div class="squadmanagement_admin_toolbar_image">';		
		$html[] = '		<img src="'.JURI::root().'components/com_squadmanagement/images/user-add2.png" style="width: 16px; height: 16px;" alt="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_ADDTO' ).'" title='.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_ADDTO' ).'" />';
		$html[] = '	</div>';
		$html[] = '</div>';	
	}
}

$html[] = '<div id="squadmanagement_admin_toolbar_item_loading" style="float:right;display: none;">';
$html[] = '	<div class="squadmanagement_admin_toolbar_image">';		
$html[] = '		<img src="'.JURI::root().'components/com_squadmanagement/images/loader.gif" style="width: 16px; height: 16px;" alt="Loading" />';
$html[] = '	</div>';
$html[] = '</div>';

$html[] = '</h1>';

$html[] = '<div class="appointmentdetails">';
$html[] = '	<div class="appointmentdetail">';

$categories =  $this->params->get('appointmentcategories','');

$list = explode("\n", $categories);

$counter = 0;

foreach ($list as $category)
{
	if ($counter == $this->item->type)
	{
		$html[] = JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_TYPE_LABEL' ) . ': ' . $category;
	}
	
	$counter++;
}		
$html[] = '	</div>';
$html[] = '	<div class="appointmentdetail">';	
$html[] = JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_STARTDATETIME_LABEL' ) . ': ' . JHtml::_('date', $this->item->startdatetime, JText::_('DATE_FORMAT_LC2'));
$html[] = '	</div>';
if ($this->item->enddatetime && $this->item->enddatetime != '0000-00-00 00:00:00')
{
	$html[] = '	<div class="appointmentdetail">';	
	$html[] = JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_ENDDATETIME_LABEL' ) . ': ' . JHtml::_('date', $this->item->enddatetime, JText::_('DATE_FORMAT_LC2'));
	$html[] = '	</div>';
}
if( $this->item->duration &&  $this->item->duration > 0)
{
	$html[] = '	<div class="appointmentdetail">';	
	$html[] = JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_DURATION_LABEL' ) . ': ' . $this->item->duration;
	$html[] = '	</div>';
}
$html[]	= '	<div class="appointmentdetail" style="display: table;">';
$html[] = '		<div style="display: table-cell;vertical-align:middle;">';
$html[] = JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_SQUAD_LABEL' ) . ': ';
$html[] = '		</div>';	
$html[] = '		<div style="float:left;display: table-cell;margin-right: 4px;">';
if ($this->item->squadimage != '')
{
	$html[] = '			<img src="'.JURI::root().$this->item->squadimage.'" alt="' . $this->item->squadname . '" style="height:20px;width:20px;" />'; 	
}
else
{
	$html[] = '			<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $this->item->squadname . '" style="height:20px;width:20px;" />'; 		
}
$html[] = '		</div>';	
$html[] = '		<div class="appointmentsquadname" style="display: table-cell;vertical-align:middle;">';
$html[] = $this->item->squadname;
$html[] = '		</div>';	
$html[] = '	</div>';	

$html[] = '	<div class="appointmentdetail">';	
$html[] = $this->item->body;
$html[] = '	</div>';
if ($this->item->members != null && count($this->item->members) > 0)
{
	$html[] = '	<div class="appointmentdetail">';
	$html[] = JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_MEMBERS_LABEL' ) . ': ';
	$html[] = '	</div>';	
}
$html[] = '	<div class="appointmentdetail">';
foreach ($this->item->members as $member)
{
	$html[] = '	<div style="float:left;margin-right:3px;">';	
	$image = IntegrationHelper::getFullAvatarImagePath($member->avatar);
	$width = ImageHelper::getImageWidth($image,50);
	
	$html[] = ' 	<img src="'.$image.'" alt="' . $member->membername . '" title="' . $member->membername . '" style="height:50px;width:'.$width.'px"/>'; 
	$html[] = '	</div>';
}
$html[] = '	</div>';	


$html[]	= '</div>';



echo implode("\n", $html); 

?>