<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of SquadManagement component
 */
class com_SquadManagementInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		$this->createImagesFolder();
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		$this->createImagesFolder();
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
	}
	
	function createImagesFolder()
	{
		jimport('joomla.filesystem.folder');

		// create a folder inside your images folder
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement');		
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'fieldicons');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'icons');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'leagues');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'logos');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'mapimages');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'opponents');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'player');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'warscreenshots');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'warscreenshots'.DIRECTORY_SEPARATOR.'thumbs');
		JFolder::create(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'squadmanagement'.DIRECTORY_SEPARATOR.'awards');
		
	}
}