window.addEvent("domready", function() {
	showRounds();
});

function showRounds()
{
    var id = jQuery("#jform_id").val();

    if (id == '')
       {
		jQuery("#squadmanagementsavefirst").show();
		jQuery("#squadmanagementprogressing").hide();
		jQuery("#squadmanagementaddround").hide();
		return;
	}

	jQuery("#squadmanagementprogressing").show();

	jQuery.getJSON('index.php?option=com_squadmanagement&format=raw&view=warrounds&warid='+id, function(response)
	{
		jQuery("#roundsDiv").html(response);	

		SqueezeBox.assign($$("a[rel=lightbox-screens]"));																				

		jQuery("#squadmanagementprogressing").hide();
	}); 													
}

function addRound()
{
	jQuery("#squadmanagementprogressing").show();		

	jQuery.getJSON('index.php?option=com_squadmanagement&format=raw&view=warround&layout=edit', function(response)
	{
		jQuery("#addroundDiv").html(response);

		SqueezeBox.assign($$("a.modal"), {
			parse: "rel"
		});

		jQuery("#squadmanagementprogressing").hide();
	}); 													
}

function removeRound(id)
{
	jQuery("#squadmanagementprogressing").show();

	jQuery.getJSON("index.php?option=com_squadmanagement&controller=squadmembers&task=removewarround&id="+id, function (response) {
	    showRounds();
	});												
}

function saveRound()
{
    var id = jQuery("#jform_id").val();
    map = jQuery('#jform_map').val();
    mapimage = jQuery('#jform_mapimage').val();
    screenshot = jQuery('#jform_screenshot').val();
    score = jQuery('#jform_roundscore').val();
    scoreopponent = jQuery('#jform_roundscoreopponent').val();

	jQuery("#squadmanagementprogressing").show();	

	jQuery.getJSON("index.php?option=com_squadmanagement&controller=squadmembers&task=savewarround&warid=" + id + "&map=" + map + "&mapimage=" + mapimage + "&screenshot=" + screenshot + "&score=" + score + "&scoreopponent=" + scoreopponent, function (response) {
	    showRounds();
	    jQuery("#addroundDiv").html("");
	});
}

function showopponentdiv() {
    jQuery("#addopponentdivprogressing").show();
    jQuery("#addopponentdiv").show();

    jQuery.getJSON('index.php?option=com_squadmanagement&format=raw&view=addopponent&layout=edit', function (response) {
        jQuery("#addopponentdivprogressing").hide();
        jQuery("#addopponentdiv").html(response);

        SqueezeBox.initialize({});
        SqueezeBox.assign($$("#addopponentdiv a.modal"), {
            parse: "rel"
        });

        $$('.hasTooltip').each(function (el) {
            var title = el.get('title');
            if (title) {
                var parts = title.split('<br />', 2);
                el.store('tip:title', parts[0]);
                el.store('tip:text', parts[1]);
            }
        });
        var JTooltips = new Tips($$('.hasTooltip'), { "maxTitleChars": 50, "fixed": false });
    });
}

function saveOpponent()
{
    var name = jQuery("#jform_name").val();
    var logo = jQuery("#jform_logo").val();
    var contact = jQuery("#jform_contact").val()
    var contactemail = jQuery("#jform_contactemail").val()
    var url = jQuery("#jform_url").val();

    jQuery("#addopponentdivprogressing").show();

    jQuery.getJSON("index.php?option=com_squadmanagement&controller=squadmembers&task=saveopponent&name=" + name + "&logo=" + logo + "&contact=" + contact + "&contactemail=" + contactemail + "&url=" + url, function (response) {
            jQuery("#addopponentdivprogressing").hide();
            jQuery("#addopponentdiv").hide();
            jQuery("#addopponentdiv").html("");
            jQuery("#jform_opponentname").val(name);

            jQuery("#jform_opponentid").append(new Option(name, -1, true, true));
    });
}