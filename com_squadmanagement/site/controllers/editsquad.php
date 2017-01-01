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

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

class SquadManagementControllerEditSquad extends JControllerForm
{
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}
	
	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('editsquad');
		
		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		$added = $model->updateItem($data);
		
		if ($added) 
		{
			$this->setRedirect( JRoute::_('index.php?option=com_squadmanagement&view=editsquad&id='. $data['id'],false),JText::_('COM_SQUADMANAGEMENT_FIELD_EDITSQUAD_SAVE_SUCCESS') );
			return true;
		} 
		
		$this->setRedirect( JRoute::_('index.php?option=com_squadmanagement&view=editsquad&id='. $data['id'],false),JText::_('COM_SQUADMANAGEMENT_FIELD_EDITSQUAD_SAVE_FAIL') );
		return false;		
	}
}
