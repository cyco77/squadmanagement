jQuery(document).ready(function () {

    jQuery('#jform_opponent').attr('autocomplete', 'off');

    jQuery('#jform_opponent').keyup(function () {
        queryOpponents();
    });
});

function queryOpponents() {
    var value = jQuery('#jform_opponent').val();
    if (value == '') {
        jQuery('#opponentsugestions').hide();
    }
    else {
        jQuery.getJSON("index.php?option=com_squadmanagement&view=challenge&format=opponentlist&namepart=" + value, function (response) {
            if (response == '') {
                jQuery('#opponenturl').show();
                jQuery('#contact').show();
                jQuery('#contactemail').show();
                jQuery('#opponentsugestions').hide();
            }
            else {
                jQuery('#opponentsugestions').html(response);
                jQuery('#opponentsugestions').show();
            }
        });
    }
}

function assignopponent(name, url) {
    jQuery('#jform_opponent').val(name);
    jQuery('#jform_opponenturl').val(url);
    jQuery('#opponentsugestions').hide();
}