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

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

abstract class JFormFieldBaseTemplate extends JFormFieldList
{
	protected $type;
	protected $folder;

	protected function getOptions() 
	{
		$path = JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->folder;
		foreach (new DirectoryIterator($path) as $file)
		{
			if($file->isDot()) continue;

			if(is_dir($path.'/'.$file->getFilename()))
			{
				$options[] = JHtml::_('select.option', $file->getFilename(), $file->getFilename());
			}
		}
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>