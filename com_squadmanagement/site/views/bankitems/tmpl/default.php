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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php');

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/com_squadmanagement/style/bankitems.css');

$html = array();

if ($this->params->get('show_page_heading', 1)) : 
	$html[] = '<h1>';
	if ($this->escape($this->params->get('page_heading'))) :
		$html[] = $this->escape($this->params->get('page_heading')); 
	else : 
		$html[] = $this->escape($this->params->get('page_title')); 
	endif;
	$html[] = '</h1>';
endif; 

$html[] = JHtml::_('tabs.start');
$html[] = JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_BANKITEM_BOOKINGS'),'panel_bankitems');	

$html[] = '<form action="'. JRoute::_('index.php?option=com_squadmanagement&view=bankitems') .'" method="post" name="adminForm" id="adminForm">';	

$html[] = '<table class="table table-striped bankitems" style="width:100%" >';

$html[] = '<thead>';
$html[] = '<tr>';
$html[] = '	<th style="text-align:center;width:20px;" >';
$html[] = '	</th>';	
$html[] = '	<th style="text-align:left;" >';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_ITEMDATETIME'); 
$html[] = '	</th>';			
$html[] = '	<th style="text-align:left;width: 30%;" class="squadmanagement_hidemobile">';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_SUBJECT'); 
$html[] = '	</th>';	
$html[] = '	<th style="text-align:right;width: 8%;" >';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_AMOUNT'); 
$html[] = '	</th>';
$html[] = '	<th style="text-align:left;width: 8%;" class="squadmanagement_hidemobile">';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_TYPE');
$html[] = '	</th>';
$html[] = '	<th style="text-align:left;" class="squadmanagement_hidemobile">';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEM_HEADING_USER');
$html[] = '	</th>';
$html[] = '</tr>';
$html[] = '</thead>';

$html[] = '<tbody>';	

foreach($this->items as $i => $item)
{					
	$html[] = '<tr>';
	
	$html[] = '<td>';
	if ($item->type == 1)
	{
		$html[] = '<img src="'.JURI::base().'components/com_squadmanagement/images/arrow_up.png" width="16" height="16" style="min-width: 16px;" alt="Up" />';												
	} 
	else
	{
		$html[] = '<img src="'.JURI::base().'components/com_squadmanagement/images/arrow_down.png" width="16" height="16" style="min-width: 16px;" alt="Down" />';												
	}	
	$html[] = '</td>';
	
	$html[] = '<td>';
	$html[] = JHtml::_('date', $item->itemdatetime, JText::_('DATE_FORMAT_LC4'));
	$html[] = '</td>';
	$html[] = '<td class="squadmanagement_hidemobile">';
	$html[] = $item->subject;
	$html[] = '</td>';
	$html[] = '<td style="text-align:right;width: 8%;">';
	if ($item->type == 1)
	{
		$style = 'squadmanagement_bankitem_incoming';	
	} 
	else
	{
		$style = 'squadmanagement_bankitem_outgoing';									
	}
	
	$html[] = '<span class="'.$style.'">'.$item->amount.'</span>';					
	$html[] = '</td>';
	$html[] = '<td class="squadmanagement_hidemobile">';
	if ($item->type == 1)
	{
		$html[] = JText::_('ALL_SQUADMANAGEMENT_BANKITEMTYPE_INCOMING');												
	} 
	else
	{
		$html[] = JText::_('ALL_SQUADMANAGEMENT_BANKITEMTYPE_OUTGOING');										
	}
	$html[] = '</td>';
	$html[] = '<td class="squadmanagement_hidemobile">';
	$html[] = $item->membername; 
	$html[] = '</td>';	
	$html[] = '</tr>';
}				

$html[] = '</tbody>';

$html[] = '<tfoot>';
$html[] = '	<tr>';
$html[] = '		<td colspan="2">';
$html[] = $this->pagination->getLimitBox();
$html[] = '		</td>';
$html[] = '		<td style="text-align:right;">';
if ($this->sum->sum > 0)
{
	$style = 'squadmanagement_bankitem_incoming';	
} 
else
{
	$style = 'squadmanagement_bankitem_outgoing';									
}

$html[] = '			<span class="'.$style.'">'.$this->sum->sum.'</span>';
$html[] = '		</td>';
$html[] = '		<td colspan="2">';
$html[] = '		</td>';
$html[] = '	</tr>';
$html[] = '	<tr>';
$html[] = '		<td colspan="5">';
$html[] = '<div class="pagination">';
$html[] = $this->pagination->getPagesLinks();
$html[] = '</div>';	
$html[] = '		</td>';
$html[] = '	</tr>';

$html[] = '</tfoot>';

$html[] = '</table>';

$html[] = '</form>';

$html[] =  JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_BANKITEM_DUESBYMEMBERS'),'panel_duesbymembers');	

$html[] = '<table class="table table-striped">';
$html[] = '		<thead>';
$html[] = '			<tr>';			
$html[] = '				<th width="1%">';
$html[] = '				</th>';
$html[] = '				<th style="text-align:left; width:20%">';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEMSMEMBERS_HEADING_MEMBER');
$html[] = '				</th>';		
$html[] = '				<th style="text-align:left;width:10%" class="squadmanagement_hidemobile">';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEMSMEMBERS_HEADING_FROMDATE');
$html[] = '				</th>';		
$html[] = '				<th style="text-align:left;width:10%" class="squadmanagement_hidemobile">';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEMSMEMBERS_HEADING_DUES');
$html[] = '				</th>';	
$html[] = '				<th style="text-align:left;width:10%" >';
$html[] = JText::_('COM_SQUADMANAGEMENT_BANKITEMSMEMBERS_HEADING_PAYEDTO');
$html[] = '				</th>';	
$html[] = '				<th width="50%" class="squadmanagement_hidemobile">';
$html[] = '				</th>';
$html[] = '			</tr>';	
$html[] = '		</thead>';
$html[] = '		<tbody>';

foreach($this->duesByMembers as $i => $member)
{
	$html[] = '<tr class="row'. $i % 2 .'">';
	$html[] = ' <td >';	
	$html[] = ' 	<img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" alt="' . $member->membername . '" style="height:35px;max-width: none;"/>'; 
	$html[] = ' </td>';	
	$html[] = ' <td >';
	$html[] = $member->membername;
	$html[] = ' </td>';
	$html[] = ' <td class="squadmanagement_hidemobile">';
	$html[] = JHtml::_('date', $member->fromdate, JText::_('DATE_FORMAT_LC4'));
	$html[] = ' </td>';
	$html[] = ' <td class="squadmanagement_hidemobile">';
	$html[] = $member->dues;
	$html[] = ' </td>';
	$html[] = ' <td>';
	if (isset($member->payedto) && $member->payedto != '0000-00-00')
	{
		$html[] = JHtml::_('date', $member->payedto, JText::_('DATE_FORMAT_LC4'));
	}
	$html[] = ' </td>';
	$html[] = ' <td class="squadmanagement_hidemobile">';

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


$html[] =  JHtml::_('tabs.panel',JText::_('COM_SQUADMANAGEMENT_BANKITEM_BANKACCOUNT'),'panel_bankaccount');	

$accountowner = $this->params->get('bankitemaccountowner','');
$accountnumber = $this->params->get('bankitemaccountnumber','');
$accountbankcode = $this->params->get('bankitemaccountbankcode','');
$accountbankname = $this->params->get('bankitemaccountbankname','');
$accountsubject = $this->params->get('bankitemaccountsubject','');
$accountiban = $this->params->get('bankitemaccountiban','');
$accountbic = $this->params->get('bankitemaccountbic','');
$bankitemaccountdescription = $this->params->get('bankitemaccountdescription','');

if ($accountowner != '') {
	$html[] = '<div><span class="squadmanagement_header">'.JText::_('COM_SQUADMANAGEMENT_BANK_ACCOUNTOWNER').'</span>'.$accountowner.'</div>';		
}

if ($accountnumber != '') {
	$html[] = '<div><span class="squadmanagement_header">'.JText::_('COM_SQUADMANAGEMENT_BANK_ACCOUNTNUMBER').'</span>'.$accountnumber.'</div>';		
}

if ($accountbankcode != '') {
	$html[] = '<div><span class="squadmanagement_header">'.JText::_('COM_SQUADMANAGEMENT_BANK_ACCOUNTBANKCODE').'</span>'.$accountbankcode.'</div>';		
}

if ($accountiban != '') {
	$html[] = '<div><span class="squadmanagement_header">'.JText::_('COM_SQUADMANAGEMENT_BANK_ACCOUNTIBAN').'</span>'.$accountiban.'</div>';		
}

if ($accountbic != '') {
	$html[] = '<div><span class="squadmanagement_header">'.JText::_('COM_SQUADMANAGEMENT_BANK_ACCOUNTBIC').'</span>'.$accountbic.'</div>';		
}

if ($accountbankname != '') {
	$html[] = '<div><span class="squadmanagement_header">'.JText::_('COM_SQUADMANAGEMENT_BANK_ACCOUNTBANKNAME').'</span>'.$accountbankname.'</div>';		
}

if ($accountsubject != '') {
	$html[] = '<div><span class="squadmanagement_header">'.JText::_('COM_SQUADMANAGEMENT_BANK_ACCOUNTSUBJECT').'</span>'.$accountsubject.'</div>';		
}

if ($bankitemaccountdescription != '') {
	$html[] = $bankitemaccountdescription;		
}

$html[] =  JHtml::_('tabs.end');	

echo implode("\n", $html); 



?>