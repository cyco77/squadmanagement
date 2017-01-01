<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squad Management!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2012 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://joomla.larshildebrandt.de
# Technical Support:  Forum - http://joomla.larshildebrandt.de/forum/index.html
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basetemplate.php');

abstract class baseAppointmentsTemplate extends baseTemplate
{
	public $appointmentlist;
	public $state;
	public $pagination;
	
	function init($appointmentlist, $pagination, $state)
	{    
		$this->appointmentlist = $appointmentlist;		
		$this->state = $state;
		$this->pagination = $pagination;
	}
}

?>