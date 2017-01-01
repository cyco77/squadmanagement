<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal'); 

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'modules/mod_squadmanagement_profile/tmpl/style.css');	

$html = array();

$showwelcome = $params->get( 'showwelcome', '0' );

if ($user->guest) {
	$html[] = 'No Access';
} else {
	$link = IntegrationHelper::getProfileLink( $userid );		

	$html[] = '<div class="squadmanagement_userprofile">';
	
	if ($showwelcome == 1)
	{		
		$html[] = '	<span class="squadmanagement_userprofile_welcome">Hi, '.'<a href="'.$link.'">'.$member->membername.'</a></span>';
	}
	$html[] = '	<div class="squadmanagement_userprofile_image">';
	$html[] = '		<a href="'.$link.'"><img src="'.IntegrationHelper::getFullAvatarImagePath($member->avatar).'" style="height:100px" alt="'.$member->membername.'" title="'.$member->membername.'" /></a>';
	$html[] = '	</div>';
	
	$html[] = '</div>';
}

echo implode("\n", $html); 	
?>

