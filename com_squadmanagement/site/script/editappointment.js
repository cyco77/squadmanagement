
function showRecurrenceControls(show) {
    if (show) {
        jQuery('#appointment_recurrence').show();
    }
    else {
        jQuery('#appointment_recurrence').hide();
    }   
}

function deleteappointment(id) {
    jQuery('#squadmanagement_admin_toolbar_item_loading').show();
    jQuery.getJSON("index.php?option=com_squadmanagement&controller=appointment&task=deleteappointment&id=" + id, function (response) {
        window.parent.window.location.href = window.parent.window.location.href;
    });
}

function addMemberToAppointment(id) {
    jQuery('#squadmanagement_admin_toolbar_item_loading').show();
    jQuery.getJSON("index.php?option=com_squadmanagement&controller=appointment&task=addtoappointment&id=" + id, function (response) {
        window.location.href = window.location.href;
    });
}

function removeMemberFromAppointment(id) {
    jQuery('#squadmanagement_admin_toolbar_item_loading').show();
    jQuery.getJSON("index.php?option=com_squadmanagement&controller=appointment&task=removefromappointment&id=" + id, function (response) {
        window.location.href = window.location.href;
    });
}