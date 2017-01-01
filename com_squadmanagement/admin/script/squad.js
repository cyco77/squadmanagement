
jQuery(document).ready(function () {
    jQuery("#username").keyup(function () {
        queryUsers();
    });
});

function queryUsers() {
    var value = jQuery('#username').val();
    if (value != '') {
        jQuery('#usernamesugestionsloader').show();
        document.adminsquadmemberForm.userid.value = "";

        jQuery.getJSON("index.php?option=com_squadmanagement&view=lookup&format=user&userpart=" + value, { })
            .done(function(response) {
                jQuery('#usernamesugestions').html(response);
                jQuery('#usernamesugestions').show();
                jQuery('#usernamesugestionsloader').hide();
            })
            .complete(function(xhr, status) {
            if (status === 'error' || !xhr.responseText) {
                console.log("Request Failed: " + status);
            } else {
                jQuery('#usernamesugestions').html(xhr.responseText);
                jQuery('#usernamesugestions').show();
            }

            jQuery('#usernamesugestionsloader').hide();
        });
    }
    else {
        jQuery('#usernamesugestions').hide();
    }
}

function assignuserid(name, id) {
    document.adminsquadmemberForm.userid.value = id;
    document.adminsquadmemberForm.username.value = name;
    jQuery('#usernamesugestions').hide();
}