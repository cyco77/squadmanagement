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

jimport('joomla.filesystem.folder');

class Componenthelper
{
	static function getVersion() 
	{ 
		$folder = JPATH_ADMINISTRATOR .DIRECTORY_SEPARATOR. 'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'; 
		if (JFolder::exists($folder)) 
		{ 
			$xmlFilesInDir = JFolder::files($folder, '.xml$'); 
		} 
		else 
		{	
			$folder = JPATH_SITE .DIRECTORY_SEPARATOR. 'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'; 
			if (JFolder::exists($folder)) 
			{ 
				$xmlFilesInDir = JFolder::files($folder, '.xml$'); 
			} 
			else 
			{ 
				$xmlFilesInDir = null; 
			} 
		} 
		
		$xml_items = ''; 
		if (count($xmlFilesInDir)) 
		{ 
			foreach ($xmlFilesInDir as $xmlfile) 
			{ 
				if ($data = JApplicationHelper::parseXMLInstallFile($folder.DIRECTORY_SEPARATOR.$xmlfile)) 
				{ 
					foreach($data as $key => $value) 
					{ 
						$xml_items[$key] = $value; 
					} 
				} 
			} 
		} 
		if (isset($xml_items['version']) && $xml_items['version'] != '' ) 
		{ 
			return $xml_items['version']; 
		} 
		else 
		{ 
			return ''; 
		} 
	}	
}

?>