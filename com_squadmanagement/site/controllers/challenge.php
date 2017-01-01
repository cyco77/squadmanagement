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

class SquadManagementControllerChallenge extends JControllerForm
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
		$model	= $this->getModel('challenge');
		
		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}
		$validate = $model->validate($form, $data);

		if ($validate === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();
			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_squadmanagement.challenge.data', $data);

			$this->setRedirect(JRoute::_('index.php?option=com_squadmanagement&view=challenge', false));
			return false;
		}

		$added = $model->insertItem($data);
		
		if ($added) 
		{
			$this->setRedirect( JRoute::_('index.php?option=com_squadmanagement&view=challenge', false),JText::_('COM_SQUADMANAGEMENT_CHALLENGE_SAVE_SUCCESS'));
		} 
		else
		{
			$app->setUserState('com_squadmanagement.challenge.data', $data);
			$this->setRedirect( 'index.php?option=com_squadmanagement&view=challenge&task=failed',false );
			return false;
		}
		
		// Flush the data from the session
		$app->setUserState('com_squadmanagement.challenge.data', null);
		
		return true;
	}
}
