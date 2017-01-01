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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'baseuserdashboardtemplate.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php');

class defaultuserdashboardtemplate extends baseUserDashBoardTemplate
{
	public function renderTemplate()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_squadmanagement/templates/userdashboard/Default/style.css');		
		
		$image = IntegrationHelper::getFullAvatarImagePath($this->view->memberInfo->avatar);
		$imageheight = 100;
		$imagewidth = ImageHelper::getImageWidth($image,$imageheight);

		$notPayedstyle = '';

		if ($this->view->usebank == 1 && $this->view->memberInfo->payedto < date('Y-m-d') )
		{
			$notPayedstyle = 'notpayed';
		}

		$html[] = '<div id="userdashboard">';
		$html[] = '	<div id="userdashboardhead" class="'.$notPayedstyle.'">';
		$html[] = '		<img id="userdashboardheadimage" src="'.$image.'" alt="' . $this->view->memberInfo->membername . '" title="' . $this->view->memberInfo->membername . '" style="height:'.$imageheight.'px;width:'.$imagewidth.'px;max-width: none;"/>'; 
		$html[] = '		<h2>'.$this->view->memberInfo->membername.'</h2>';

		if ($this->view->usebank == 1)
		{
			$html[] = '	<div id="userdashboardbankpayedto">';
			if ($this->view->memberInfo->payedto < date('Y-m-d') )
			{
				$statusImage = '<img id="userdashboardbankpayedtoimage" src="'.JURI::base().'components/com_squadmanagement/images/status_red.jpg" alt="" title="" style="height:24px;width:24px;max-width: none;"/>';
				$html[] = '<div id="userdashboardbankpayedtostatus">';
				$html[] = $statusImage;
				$html[] = '</div>';
			}
			
			$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_PAYEDTO') . JHtml::_('date', $this->view->memberInfo->payedto, JText::_('COM_SQUADMANAGEMENT_DATE'));
			$html[] = '	</div>';
			
			if (isset($this->view->lastBankItem))
			{
				$html[] = '	<div id="userdashboardbanklastbankitem">';
				$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_LASTPAYMENT') . JHtml::_('date', $this->view->lastBankItem->itemdatetime, JText::_('COM_SQUADMANAGEMENT_DATE')).' ('.$this->view->lastBankItem->amount.')';
				$html[] = '	</div>';
			}
		}

		$html[] = '	</div>';
		$html[] = '	<div style="clear:both;">';

		// My Appointments 		

		$html[] = '<table>';
		$html[] = '<thead>';
		$html[] = '	<tr class="thead" >';
		$html[] = '		<th class="tablecaption" colspan="5">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_APPOINTMENTS_TITLE');
		$html[] = '		</th>';
		$html[] = '	</tr>';
		$html[] = '</thead>';
		$html[] = '<thead>';
		$html[] = '	<tr class="tr">';
		$html[] = '		<th class="th state">';
		$html[] = '		</th>';
		$html[] = '		<th class="th coldatetime">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_APPOINTMENTS_DATETIME');
		$html[] = '		</th>';
		$html[] = '		<th class="th colmax">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_APPOINTMENTS_SUBJECT');
		$html[] = '		</th>';
		$html[] = '		<th class="th col">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_APPOINTMENTS_SQUADNAME');
		$html[] = '		</th>';
		$html[] = '		<th class="th col">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_APPOINTMENTS_STATE');
		$html[] = '		</th state>';
		$html[] = '	</tr>';
		$html[] = '</thead>';

		$html[] = '<tbody>';
		foreach ($this->view->appointments as $appointment)
		{
			$link = JRoute::_( 'index.php?option=com_squadmanagement&view=appointment&tmpl=component&id='. $appointment->id );	
			
			$html[] = '	<tr class="tr">';
			$html[] = '		<td class="td state">';
			if ($appointment->state == '0')
			{
				$html[] = '		<img id="userdashboardbankpayedtoimage" src="'.JURI::base().'components/com_squadmanagement/images/status_green.jpg" alt="" title="" style="height:16px;width:16px;max-width: none;"/>';	
			}
			else
			{
				$html[] = '		<img id="userdashboardbankpayedtoimage" src="'.JURI::base().'components/com_squadmanagement/images/status_red.jpg" alt="" title="" style="height:16px;width:16px;max-width: none;"/>';	
			}	
			$html[] = '		</td>';
			$html[] = '		<td class="td coldatetime">';
			$html[] = '			<a href="'.$link.'" class="modal" rel="{handler: \'iframe\', size: {x: 400, y: 300}}">';
			$html[] = JHtml::_('date', $appointment->startdatetime, JText::_('COM_SQUADMANAGEMENT_DATETIME'));
			$html[] = '			</a>';
			$html[] = '		</td>';
			$html[] = '		<td class="td">';	
			$html[] = $appointment->subject;
			$html[] = '		</td>';	
			$html[] = '		<td class="td">';
			$html[] = $appointment->squadname;
			$html[] = '		</td>';
			$html[] = '		<td class="td state">';

			if ($appointment->state == '0')
			{
				$html[] = '<div class="squadmanagement_admin_toolbar_item" onclick="removeMemberFromAppointment('.$appointment->id.');">';
				$html[] = '	<div class="squadmanagement_admin_toolbar_image">';		
				$html[] = '		<img src="'.JURI::root().'components/com_squadmanagement/images/user-delete2.png" style="width: 16px; height: 16px;max-width: none;" alt="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_REMOVEFROM' ).'" title="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_REMOVEFROM' ).'" />';
				$html[] = '	</div>';
				$html[] = '</div>';
			}
			else
			{
				$html[] = '<div class="squadmanagement_admin_toolbar_item" onclick="addMemberToAppointment('.$appointment->id.');">';
				$html[] = '	<div class="squadmanagement_admin_toolbar_image">';		
				$html[] = '		<img src="'.JURI::root().'components/com_squadmanagement/images/user-add2.png" style="width: 16px; height: 16px;max-width: none;" alt="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_ADDTO' ).'" title='.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_ADDTO' ).'" />';
				$html[] = '	</div>';
				$html[] = '</div>';	
			}

			$html[] = '		</td>';
			$html[] = '	</tr>';
		}
		
		$html[] = '</tbody>';
		$html[] = '</table>';

		// My Wars 

		$html[] = '<table class="table" id="userdashboardappointments">';
		$html[] = '<thead>';
		$html[] = '	<tr class="thead">';
		$html[] = '		<th class="tablecaption" colspan="6">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_WARS');
		$html[] = '		</th>';
		$html[] = '	</tr>';
		$html[] = '</thead>';
		$html[] = '<thead>';
		$html[] = '	<tr class="tr">';
		$html[] = '		<th class="th state">';
		$html[] = '		</th>';
		$html[] = '		<th class="th coldatetime">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_WARS_DATETIME');
		$html[] = '		</th>';
		$html[] = '		<th class="th colmax">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_WARS_OPPONENT');
		$html[] = '		</th>';
		$html[] = '		<th class="th col">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_WARS_LEAGUE');
		$html[] = '		</th>';
		$html[] = '		<th class="th col">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_WARS_SQUADNAME');
		$html[] = '		</th>';
		$html[] = '		<th class="th col">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_USERDASHBOARD_WARS_STATE');
		$html[] = '		</th state>';
		$html[] = '	</tr>';
		$html[] = '</thead>';

		$html[] = '<tbody>';
		foreach ($this->view->wars as $war)
		{
			$link = JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&id='. $war->id );		
			
			$html[] = '	<tr class="tr">';
			$html[] = '		<td class="td state">';
			if ($war->state == 1)
			{
				$html[] = '		<img id="userdashboardbankpayedtoimage" src="'.JURI::base().'components/com_squadmanagement/images/status_green.jpg" alt="" title="" style="height:16px;width:16px;max-width: none;"/>';	
			}
			else
			{
				$html[] = '		<img id="userdashboardbankpayedtoimage" src="'.JURI::base().'components/com_squadmanagement/images/status_red.jpg" alt="" title="" style="height:16px;width:16px;max-width: none;"/>';	
			}

			$html[] = '		</td>';
			$html[] = '		<td class="td coldatetime">';
			$html[] = '			<a href="'.$link.'">';
			$html[] = JHtml::_('date', $war->wardatetime, JText::_('COM_SQUADMANAGEMENT_DATETIME'));
			$html[] = '			</a>';
			$html[] = '		</td>';
			$html[] = '		<td class="td ">';
			$html[] = $war->opponentname;
			$html[] = '		</td>';
			$html[] = '		<td class="td">';
			$html[] = $war->leaguename;
			$html[] = '		</td>';
			$html[] = '		<td class="td">';
			$html[] = $war->squadname;
			$html[] = '		</td>';
			$html[] = '		<td class="td state">';

			$link = JRoute::_( 'index.php?option=com_squadmanagement&tmpl=component&view=updatewarmemberstate&warid='. $war->id );
			
			$html[] = '<a href="'.$link.'" class="modal" rel="{handler: \'iframe\', size: {x: 550, y: 400}}"  >';
			$html[] = '	<div class="squadmanagement_admin_toolbar_item">';
			$html[] = '		<div class="squadmanagement_admin_toolbar_image">';		
			
			if ($war->state == 1)
			{
				$html[] = '		<img src="'.JURI::root().'components/com_squadmanagement/images/user-delete2.png" style="width: 16px; height: 16px;max-width: none;" alt="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_REMOVEFROM' ).'" title="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_REMOVEFROM' ).'" />';			
			}
			else
			{
				$html[] = '		<img src="'.JURI::root().'components/com_squadmanagement/images/user-add2.png" style="width: 16px; height: 16px;max-width: none;" alt="'.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_ADDTO' ).'" title='.JText::_( 'COM_SQUADMANAGEMENT_APPOINTMENT_ADDTO' ).'" />';		
			}
			
			$html[] = '		</div>';
			$html[] = '	</div>';		
			$html[] = '</a>';

			$html[] = '		</td>';
			$html[] = '	</tr>';
		}
		
		$html[] = '</tbody>';
		$html[] = '</table>';

		$html[] = '	</div>';
		$html[] = '</div>';

		echo implode("\n", $html); 
	}	
}
