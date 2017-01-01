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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'baseawardstemplate.php');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php');

class defaultawardstemplate extends baseawardstemplate
{
	public function renderTemplate()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_squadmanagement/templates/awards/Default/style.css');		
		
		$html = array();
		
		$html[] = '<div>';
		
		if (count($this->awardlist) == 0) {
			$html[] = JText::_('COM_SQUADMANAGEMENT_NO_AWARDS');
		}
		else 
		{	
			
			$html[] = '<form action="'. JRoute::_('index.php?option=com_squadmanagement&view=awards') .'" method="post" name="adminForm" id="adminForm">';	
			
			$html[] = '<fieldset id="filter-bar">';
			$html[] = '<div class="filter-select fltrt">';
			$html[] = $this->pagination->getLimitBox();
			$html[] = '</div>';
			$html[] = '</fieldset>';	
			
			$html[] = '<table id="awardstemplate_awards">';
			
			$html[] = '<thead>';
			$html[] = '<tr>';
			$html[] = '	<th></th>';
			$html[] = '	<th class="squadmanagement_awards_place" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_PLACE'); 
			$html[] = '	</th>';			
			$html[] = '	<th class="squadmanagement_awards_name" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_NAME'); 
			$html[] = '	</th>';	
			$html[] = '	<th class="squadmanagement_awards_squad" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_SQUAD'); 
			$html[] = '	</th>';
			$html[] = '	<th class="squadmanagement_awards_url" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_URL');
			$html[] = '	</th>';
			$html[] = '	<th class="squadmanagement_awards_date" >';
			$html[] = JText::_('COM_SQUADMANAGEMENT_AWARD_HEADING_AWARDDATE');
			$html[] = '	</th>';
			$html[] = '</tr>';
			$html[] = '</thead>';
			
			$html[] = '<tbody>';	
			
			foreach($this->awardlist as $i => $item)
			{					
				$link = JRoute::_( 'index.php?option=com_squadmanagement&view=award&tmpl=component&id='. $item->id );				
				
				$html[] = '<tr>';
				$html[] = '<td>';

				if ($item->imageurl != '')
				{
					$html[] = '<img src="'.JURI::root().$item->imageurl.'" alt="' . $item->name . '" style="height:20px;width:20px;max-width: none;"/>'; 	
				}
				else
				{
					$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $item->name . '" style="height:20px;width:20px;max-width: none;"/>'; 		
				}
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_awards_place">';
				$html[] = $item->place;
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_awards_name">';
				$html[] = '	<a href="'.$link.'" class="modal" rel="{handler: \'iframe\', size: {x: 400, y: 400}}">';
				$html[] = $item->name;
				$html[] = '</a>';				
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_awards_squad">';
				$html[] = $item->squadname;
				$html[] = '</td>';
				$html[] = '<td class="squadmanagement_awards_url">';
				if ($item->url != '')
				{
					$html[] = '<a href="'.$item->url.'">'.$item->url.'</a>'; 
				}
				$html[] = '</td>';	
				$html[] = '<td  class="squadmanagement_awards_date">';
				$html[] = JHtml::_('date', $item->awarddate, JText::_('COM_SQUADMANAGEMENT_DATE'));
				$html[] = '</td>';
				$html[] = '</tr>';
			}				
			
			$html[] = '</tbody>';

			$html[] = '</table>';
			
			$html[] = '<div class="pagination">';
			$html[] = '</div>';				
			
			$html[] = '</form>';
		}	
				
		$html[] = '</div>';
		
		echo implode("\n", $html); 
	}	
}
