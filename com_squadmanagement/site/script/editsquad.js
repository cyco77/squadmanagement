jQuery(document).ready(function () {
    jQuery("#system-message-container").fadeOut(2500);

    getMemberlist(jQuery('#jform_id').val());
});

function getMemberlist(squadid) {
    jQuery.getJSON("index.php?option=com_squadmanagement&view=editsquad&format=memberlist&squadid=" + squadid, function (response) {
        jQuery('#memberlist').html(response);
    });
}

function removeSquadMember(id,squadid) {
    jQuery.getJSON("index.php?option=com_squadmanagement&controller=squadmembers&task=removemember&id=" + id + "&squadid=" + squadid, function (response) {
    });

    jQuery("#squadmemberrow_" + id).fadeOut(500);
}

function queryUsers(squadid) {
    var userpart = jQuery('#usernamefilter').val();
    if (userpart != '') {
        jQuery.getJSON("index.php?option=com_squadmanagement&view=editsquad&format=userlookup&userpart=" + userpart + "&squadid=" + squadid, function (response) {
            jQuery('#usernamesugestions').html(response);
            jQuery('#usernamesugestions').show();
        });
    }
    else {
        jQuery('#usernamesugestions').hide();
    }
}

function assignsquadmember(name, id) {
    jQuery('#userid').val(id);
    jQuery('#usernamefilter').val(name);
    jQuery('#usernamesugestions').hide();
}

function addSquadMember(squadid) {
    var name = jQuery('#usernamefilter').val();
    var role = jQuery('#role').val();
    var userid = jQuery('#userid').val();
    if (userid != '') {
        jQuery.getJSON("index.php?option=com_squadmanagement&controller=squadmembers&task=addmember&squadid=" + squadid + "&userid=" + userid + "&role=" + role, function (response) {
            jQuery('#userid').val('');
            jQuery('#usernamefilter').val('');
            jQuery('#usernamesugestions').hide();

            getMemberlist(jQuery('#jform_id').val());
        });
    }
}