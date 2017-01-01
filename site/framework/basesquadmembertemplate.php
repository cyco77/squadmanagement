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

abstract class baseSquadmemberTemplate extends baseTemplate
{
	public $squadmember;
	public $tablist;
	public $fieldlist;
	
	function init($squadmember, $additionaltabs, $fieldlist)
	{    
		$this->squadmember = $squadmember;	
		$this->tablist = $additionaltabs;	
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