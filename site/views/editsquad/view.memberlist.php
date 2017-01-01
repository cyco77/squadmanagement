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

jimport( 'joomla.application.component.view' );

class SquadManagementViewEditsquad extends JViewLegacy
{
	function display($tpl = null)
	{	
		$params = JComponentHelper::getParams( 'com_squadmanagement' ); 
		$this->assignRef('params',$params);
		
		$squadid = JRequest::getVar( 'squadid', '', 'default', 'string' );	
		if ($squadid == '')
		{			
			parent::display('noaccess');
			return false;
		}
		
		$model = $this->getModel(); 
		$squad = $model->getData($squadid);
		
		if ($squad == null)
		{			
			parent::display('noaccess');
			return false;
		}
		
		$this->assignRef('squad', $squad);		
		
		$user = JFactory::getUser();
		$userid = $user->get('id');
		if ($userid != $squad->squadleader)
		{			
			parent::display('noaccess');
			return false;
		}		
		
		parent::display("memberlist");
	}
	
}