
window.addEvent('domready', function () {
    showRounds();
});

function showRounds() {
    var id = jQuery("#jform_id").val();

    if (id == '') {
        jQuery("#squadmanagementsavefirst").show();
        jQuery("#squadmanagementprogressing").hide();
        jQuery("#squadmanagementaddround").hide();
        return;
    }
    jQuery("#squadmanagementsavefirst").hide();

    jQuery('#squadmanagementprogressing').show();

    jQuery.getJSON("index.php?option=com_squadmanagement&format=raw&view=warrounds&warid=" + id, {})
        .complete(function(xhr, status) {
        if (status === 'error' || !xhr.responseText) {
            console.log("Request Failed: " + status);
        } else {
            jQuery('#roundsDiv').html(xhr.responseText);
            jQuery('#usernamesugestions').show();
        }

        jQuery('#squadmanagementprogressing').hide();

        SqueezeBox.assign($$('a[rel=lightbox-screens]'));
    });
}

function addRound() {
    jQuery('#squadmanagementprogressing').show();

    jQuery.getJSON("index.php?option=com_squadmanagement&format=raw&view=warround&layout=edit", {})
    .complete(function(xhr, status) {
        if (status === 'error' || !xhr.responseText) {
            console.log("Request Failed: " + status);
        } else {
            jQuery('#addroundDiv').html(xhr.responseText);
        }

        jQuery('#squadmanagementprogressing').hide();

        SqueezeBox.assign($$('a.modal'), {
            parse: 'rel'
        });
    });
}

function removeRound(id) {
    jQuery('#squadmanagementprogressing').show();

    jQuery.ajax({ url: "index.php?option=com_squadmanagement&task=removewarround&id=" + id }).done(function () {
        showRounds();
    });
}

function saveRound() {
    var id = jQuery("#jform_id").val();
    var map = jQuery('#jform_map').val();
    var mapimage = jQuery('#jform_mapimage').val();
    var screenshot = jQuery('#jform_screenshot').val();
    var score = jQuery('#jform_roundscore').val();
    var scoreopponent = jQuery('#jform_roundscoreopponent').val();

    jQuery('#squadmanagementprogressing').show();

    jQuery.ajax({ url: "index.php?option=com_squadmanagement&task=savewarround&warid=" + id + "&map=" + map + "&mapimage=" + mapimage + "&screenshot=" + screenshot + "&score=" + score + "&scoreopponent=" + scoreopponent }).done(function () {
        showRounds();
        jQuery('#addroundDiv').html('');
    });
}