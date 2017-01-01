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
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basetemplate.php');

abstract class baseWarListTemplate extends baseTemplate
{
	public $warlist;
	public $state;
	public $pagination;
	var $wartemplatename;
	
	function init($warlist,$pagination,$summary,&$state,$wartemplatename)
	{    
		$this->warlist = $warlist;		
		$this->pagination = $pagination;
		$this->state = $state;		
		$this->wartemplatename = $wartemplatename;
		$this->summary = $summary;
	}
	
	public function getWarLink($id)
	{
		if ($this->wartemplatename != '')
		{
			return JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&wartemplate='.$this->wartemplatename.'&id='. $id );	
		}
		else
		{
			return JRoute::_( 'index.php?option=com_squadmanagement&amp;view=war&id='. $id );	
		}
	}	
	
	function getWinCount()
	{
		return $this->getSummaryValue(1);		
	}
	
	function getDrawCount()
	{
		return $this->getSummaryValue(0);		
	}
	
	function getLostCount()
	{
		return $this->getSummaryValue(-1);		
	}
	
	function getSummaryValue($result)
	{
		foreach ($this->summary as $value)
		{
			if ($value->result == $result)
			{
				return $value->number;	
			}	
		}
		
		return 0;	
	}
}

?>