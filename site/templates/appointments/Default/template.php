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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'baseappointmentstemplate.php');

class defaultappointmentstemplate extends baseAppointmentsTemplate
{
	public function renderTemplate()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_squadmanagement/templates/appointments/Default/style.css');		
		
		$html = array();
		
		$html[] = '<form action="'. JRoute::_('index.php?option=com_squadmanagement&view=appointments') .'" method="post" name="adminForm" id="adminForm">';

		$html[] = '<fieldset id="filter-bar">';
		$html[] = '<div class="filter-select fltrt">';
		$html[] = $this->pagination->getLimitBox();
		$html[] = '</div>';
		$html[] = '</fieldset>';	

		$html[] = '<table id="appointmentslist" class="table table-striped" id="articleList">';
		$html[] = '		<thead>';
		$html[] = '			<tr>';
		$html[] = '				<th style="text-align:left;width: 20%;">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_APPOINTMENT_HEADING_SUBJECT');
		$html[] = '             </th>';
		$html[] = '				<th style="text-align:left;width: 20%;" class="nowrap hidden-phone">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_APPOINTMENT_HEADING_TYPE');
		$html[] = '             </th>';
		$html[] = '				<th style="text-align:left;width: 25%;">';
		$html[] = JText::_('COM_SQUADMANAGEMENT_APPOINTMENT_HEADING_START');
		$html[] = '             </th>';
		$html[] = '				<th style="width: 25px;"></th>';
		$html[] = '				<th style="text-align:left" class="nowrap hidden-phone">';
		$html[] =  JText::_('COM_SQUADMANAGEMENT_APPOINTMENT_HEADING_SQUAD');
		$html[] = '				</th>';
		$html[] = '			</tr>';
		$html[] = '		</thead>';
		$html[] = '		<tbody>';

		$params = JComponentHelper::getParams( 'com_squadmanagement' ); 

		foreach($this->appointmentlist as $i => $item)
		{
			$link = JRoute::_( 'index.php?option=com_squadmanagement&view=appointment&tmpl=component&id='. $item->id );
			
			$pageNav = $this->pagination;
			$html[] = '			<tr class="row'. $i % 2 .'">';
			$html[] = '				<td>';
			$html[] = '	<a href="'.$link.'" class="modal" rel="{handler: \'iframe\', size: {x: 400, y: 300}}">';
			$html[] = $item->subject;
			$html[] = '</a>';
			$html[] = '				</td>';
			$html[] = '				<td class="nowrap hidden-phone">';				
			
			$categories =  $params->get('appointmentcategories','');

			$list = explode("\n", $categories);

			$counter = 0;

			foreach ($list as $category)
			{
				if ($counter == $item->type)
				{
					$html[] = $category;
				}
				
				$counter++;
			}		
			
			$html[] = '				</td>';
			$html[] = '				<td>';
			$html[] = JHtml::_('date', $item->startdatetime,JText::_('DATE_FORMAT_LC2'));
			$html[] = '				</td>';		
			$html[] = '				<td class="nowrap hidden-phone appointmentslist_squadimage">';
			if ($item->squadlogo != '')
			{
				$html[] = '<img src="'.JURI::root().$item->squadlogo.'" alt="' . $item->squadname . '" style="height:20px;width:20px;max-width: none;"/>'; 	
			}
			else
			{
				$html[] = '<img  src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->squadname . '" style="height:20px;width:20px;max-width: none;"/>'; 		
			}
			$html[] = '				</td>';
			$html[] = '				<td class="nowrap hidden-phone">';
			$html[] = $item->squadname;
			$html[] = '				</td>';	
			$html[] = '			</tr>';
		}
		
		$html[] = '		</tbody>';
		$html[] = '	</table>';
		
		$html[] = '<div class="pagination">';
		$html[] = $this->pagination->getPagesLinks();
		$html[] = '</div>';	

		$html[] = '</form>';
		
		echo implode("\n", $html); 
	}	
}
