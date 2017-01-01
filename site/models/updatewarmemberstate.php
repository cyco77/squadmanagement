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

// import Joomla modelform library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_squadmanagement'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'squadmanagement.php';	

class SquadManagementModelUpdateWarMemberState extends JModelForm
{
	protected function populateState()
	{		
		$params = JFactory::getApplication()->getParams();
		$this->setState('params', $params);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_squadmanagement.updatewarmemberstate', 'updatewarmemberstate', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		return $form;
	}
	
	protected function loadFormData()
	{
		$data = (array)JFactory::getApplication()->getUserState('com_squadmanagement.updatewarmemberstate.data', array());
		if (empty($data)) 
		{
			$warid = JRequest::getVar( 'warid', '', 'default', 'int' );

			$data = $this->getData($warid);
		}
		return $data;
	}
	
	public function getData($warid)
	{					
		$user = JFactory::getUser();
		$user_id = $user->get('id');
			
		$query = ' SELECT * 
			FROM #__squad_war_member
			WHERE warid = '.$warid.' and memberid = '.$user_id;
		$this->_db->setQuery( $query );
		$data = $this->_db->loadObject();
		
		return $data;
	}
	
	public function updateItem($data)
	{
		$user = JFactory::getUser();
		$user_id = $user->get('id');
		
		$warid = JRequest::getVar('warid');

		$db = JFactory::getDbo();	
		$query = $db->getQuery(true);
		
		if (isset($data['id']) && $data['id'] != '')
		{
			$query->update('#__squad_war_member');
			$query->where('warid = ' . $warid . ' AND memberid = ' . $user_id);
		}
		else
		{
			$query->insert('#__squad_war_member');
			$query->set('warid = '.$db->quote($warid));
			$query->set('memberid = '.$db->quote($user_id));
		}

		$query->set('state = '.$db->quote($data['state']));				
		$query->set('comment = '.$db->quote($data['comment']));
			
		$db->setQuery($query);
		
		$result = $db->query();
				
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} 
		else 
		{
			return true;
		}
	}
}
