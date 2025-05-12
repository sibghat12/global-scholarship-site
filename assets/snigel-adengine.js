// snigel-adengine.js
document.addEventListener('DOMContentLoaded', function() {
    var postType = snigelAdConfig.postType || 'page';

    window.snigelPubConf = {
        "adengine": {
            "activeAdUnits": postType === 'post' || postType === 'institution' ? ["incontent_1"] : ["interstitial"]
        }
    };

    var script = document.createElement('script');
    script.async = true;
    script.setAttribute('data-cfasync', 'false');
    script.src = "https://cdn.snigelweb.com/adengine/globalscholarships.com/loader.js";
    document.head.appendChild(script);
});
