<?php
/*------------------------------------------------------------------------
# com_squadmanagement - Squadmanagement!
# ------------------------------------------------------------------------
# author    Lars Hildebrandt
# copyright Copyright (C) 2012 Lars Hildebrandt. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://joomla.larshildebrandt.de
# Technical Support:  Forum - http://joomla.larshildebrandt.de/forum/index.html
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );

class SquadManagementViewBankItem extends JViewLegacy
{
	function display($tpl = null)
	{	
		$userid = JRequest::getVar( 'userid', '', 'default', 'string' );	
		
		$model = $this->getModel(); 
		$data = $model->getUserData($userid);
				
		$this->assignRef('data', $data);				
		
		parent::display("memberinfo");
	}
	
}