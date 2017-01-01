jQuery(document).ready(function () {
    getMemberInfos();
});

function getMemberInfos() {

    jQuery('#jform_dues').val('');
    jQuery('#jform_payedto_hidden').val('');
    jQuery('#memberInfo').hide();
    jQuery('#memberInfodue').hide();

    var userid = jQuery('#jform_userid_id').val();
    if (userid != 0) {        
        jQuery('#memberInfoloader').show();

        jQuery.getJSON("index.php?option=com_squadmanagement&view=bankitem&format=memberinfo&userid=" + userid,   { })
        .complete(function (xhr, status) {
            if (status === 'error' || !xhr.responseText) {
                console.log("Request Failed: " + status);
            } else {
                jQuery('#memberInfo').html(xhr.responseText);
                jQuery('#memberInfo').show();
                jQuery('#memberInfodue').show();
                updatePayedTo();
            };
            
            jQuery('#memberInfoloader').hide();
        });
    }
}

function updatePayedTo() {

    var id = jQuery('#jform_id').val();
    if (id == '') {
        var amount = jQuery('#jform_amount').val();
        var due = jQuery('#jform_dues').val();
        var payedto = jQuery('#jform_payedto_hidden').val();

        if (payedto != '') {
            var monthCount = amount / due;

            var timeZoneOffset = new Date().getTimezoneOffset() / 60;

            var myDate = new Date(payedto);
            myDate.setMonth(myDate.getMonth() + monthCount);
            myDate.setHours(myDate.getHours() + timeZoneOffset);

            var year = myDate.getFullYear();
            var month = myDate.getMonth()+1;
            if (month < 10) { month = '0' + month; }
            var day = myDate.getDate();
            if (day < 10) { day = '0' + day; }

            jQuery('#jform_payedto').val(year+'-'+month+'-'+day);
        }
    }
}
