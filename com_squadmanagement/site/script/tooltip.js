window.addEvent('domready', function () {
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
