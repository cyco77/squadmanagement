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

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basetemplate.php');

abstract class baseSquadListTemplate extends baseTemplate
{
	public $squadlist;
	public $fieldlist;
	public $params;
	
	function init($squadlist, $fieldlist)
	{    
		$this->squadlist = $squadlist;		
		$this->fieldlist = $fieldlist;
	}
	
	public function getImageUrlOrDefault($imageurl)
	{
		if ($imageurl == '')
		{
			return 'components/com_squadmanagement/images/unknownuser.jpg';
		}
		
		return $imageurl;
	}
}

?>