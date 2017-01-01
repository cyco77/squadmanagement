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

// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'script'.DIRECTORY_SEPARATOR.'steam'.DIRECTORY_SEPARATOR.'SteamUtility.php';		
require_once JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'script'.DIRECTORY_SEPARATOR.'steam'.DIRECTORY_SEPARATOR.'SteamUser.php';		

class SquadManagementModelSquadMember extends JModelItem
{
	protected $_data;

	public function getTable($type = 'SquadMember', $prefix = 'SquadManagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function &getData($id)
	{
		if (empty( $this->_data )) {
			
			require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'integrationhelper.php';		
			
			$avatarjoin = IntegrationHelper::getAvatarSqlJoin('i');
			$avatarselect = IntegrationHelper::getAvatarSqlSelect();
			
			$membernameField = IntegrationHelper::getMembernameField();
			
			$query = ' SELECT '. $membernameField .', i.* '.$avatarselect.' FROM #__users u INNER JOIN #__squad_member_additional_info i ON u.id = i.userid '. $avatarjoin . '  WHERE i.userid = '.$id;
			
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
			
			if ($this->_data->steamid != '')
			{
				$steamId64 = SteamUtility::steamIdToSteamId64($this->_data->steamid);
				
				$steamData = new SteamUser($steamId64);
				
				$this->_data->steamdata = $steamData;
				
				if (isset($this->_data->steamdata->mostPlayedGames))
				{
					foreach($this->_data->steamdata->mostPlayedGames as $game)
					{
						$achievements = $steamData->getAchievements($game->statsName);
						if (isset($achievements))
						{
							$game->achievements = $achievements;
							
						}
					}
				}
			}
		}
		
		return $this->_data;
	}
	
	public function getProfileFields()
	{
		$query = 'SELECT * FROM #__squad_member_additional_field WHERE showinprofile = 1 AND published = 1 ORDER BY ordering';	
		$db = $this->getDbo();
		
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	public function getProfileTabs()
	{
		$query = 'SELECT * FROM #__squad_member_additional_tab WHERE published = 1 ORDER BY ordering';	
		$db = $this->getDbo();
		
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		
		$params = $app->getParams();
		$this->setState('params', $params);
	}
}

?>