(function () {
    'use strict';

    var gpc = navigator.globalPrivacyControl === true;
    var dnt = navigator.doNotTrack === '1' || navigator.doNotTrack === 'yes' ||
        window.doNotTrack === '1' || window.doNotTrack === 'yes';
    var optedOut = false;
    try {
        optedOut = localStorage.getItem('site_analytics_opt_out') === '1';
    } catch (error) {
        optedOut = false;
    }
    if (gpc || dnt || optedOut) return;

    function safeReferrer() {
        if (!document.referrer) return '';
        try {
            var parsed = new URL(document.referrer);
            return parsed.origin + parsed.pathname;
        } catch (error) {
            return '';
        }
    }

    var payload = JSON.stringify({
        page: window.location.pathname,
        title: document.title,
        referrer: safeReferrer(),
        language: navigator.language || '',
        timezone: (function () {
            try { return Intl.DateTimeFormat().resolvedOptions().timeZone || ''; }
            catch (error) { return ''; }
        })(),
        screen_width: window.screen ? window.screen.width : null,
        screen_height: window.screen ? window.screen.height : null
    });
    var endpoint = '/devsite/iainreiddotdev/analytics/collect.php';

    if (navigator.sendBeacon) {
        navigator.sendBeacon(endpoint, new Blob([payload], {type: 'text/plain;charset=UTF-8'}));
        return;
    }
    fetch(endpoint, {
        method: 'POST',
        body: payload,
        headers: {'Content-Type': 'text/plain;charset=UTF-8'},
        credentials: 'omit',
        keepalive: true
    }).catch(function () {});
})();
