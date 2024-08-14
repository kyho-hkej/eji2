<!-- DFP --> 

(function() {
var useSSL = 'https:' == document.location.protocol;
var src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
document.write('<scr' + 'ipt async=\'async\' src="' + src + '"></scr' + 'ipt>');
})();

var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];

<!-- DFP --> 

<!-- DFP custom targeting banner ad for specific hashtag -->
<!-- get hashtag from URL -->

var href = location.href;
var group = location.href;
if (group.indexOf("searchGeneral") > 0 ) {
	group = href.match(/([^\/]*)\/*$/)[1];
	var h=group.replace('searchGeneral?q=','');
	if (group.indexOf("&hidden_search=1&titlebar=1") > 0 ) {
		h=group.replace('&hidden_search=1&titlebar=1','');
	}
	var uri_dec = decodeURIComponent(h);
	hashtag = uri_dec.replace("#", "%23");
	hashtag = hashtag.replace("#", "%23");
	//hashtag = '%23'+uri_dec+'%23';
} else if (group.indexOf('article') > 0){
	//hashtag=tags.split(",");
    hashtag ='';
} else {
group = href.match(/([^\/]*)\/*$/)[1];
hashtag = '%23'+group+'%23';
}
console.log(group);
console.log('hashtag='+hashtag);
<!-- I.E. 9 matchMedia--> 	
window.matchMedia || (window.matchMedia = function() {
    "use strict";

    // For browsers that support matchMedium api such as IE 9 and webkit
    var styleMedia = (window.styleMedia || window.media);

    // For those that don't support matchMedium
    if (!styleMedia) {
        var style       = document.createElement('style'),
            script      = document.getElementsByTagName('script')[0],
            info        = null;

        style.type  = 'text/css';
        style.id    = 'matchmediajs-test';

        script.parentNode.insertBefore(style, script);

        // 'style.currentStyle' is used by IE <= 8 and 'window.getComputedStyle' for all other browsers
        info = ('getComputedStyle' in window) && window.getComputedStyle(style, null) || style.currentStyle;

        styleMedia = {
            matchMedium: function(media) {
                var text = '@media ' + media + '{ #matchmediajs-test { width: 1px; } }';

                // 'style.styleSheet' is used by IE <= 8 and 'style.textContent' for all other browsers
                if (style.styleSheet) {
                    style.styleSheet.cssText = text;
                } else {
                    style.textContent = text;
                }

                // Test if media query is true or false
                return info.width === '1px';
            }
        };
    }

    return function(media) {
        return {
            matches: styleMedia.matchMedium(media || 'all'),
            media: media || 'all'
        };
    };
}());
<!-- I.E. 9 matchMedia--> 
   
 <!-- detect screen & AD Tag function --> 
	 
function mobileviewad(adpath,dim,gptid) {
 if (window.matchMedia('(max-width: 970px)').matches)
 { 
 	    googletag.cmd.push(function() {
        var slot1 = googletag.defineSlot(adpath, dim, gptid).addService(googletag.pubads()).setCollapseEmptyDiv(true,true)
        .setTargeting("keyword", [hashtag]);        
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
        googletag.display(gptid);
        });		
 }
else {} 	
}

function desktopviewad(adpath,dim,gptid) {
 if (window.matchMedia('(min-width: 970px)').matches)
 { 	 
 	    googletag.cmd.push(function() {
        var slot1 = googletag.defineSlot(adpath, dim, gptid).addService(googletag.pubads()).setCollapseEmptyDiv(true,true)
        //.setTargeting("sport", ["rugby", "rowing"])
        //.setTargeting("keyword", hashtag);
			  //	.setTargeting("keyword", ["%23千膚所指%23", "%23皮膚科%23", "%23侯鈞翔%23", "%23玻尿酸%23", "%23透明質酸%23", "%2350%23"]);
				.setTargeting("keyword", [hashtag]);
        googletag.pubads().enableSingleRequest();
        googletag.enableServices();
        googletag.display(gptid);
        });		
 }
else {} 	
}
 <!-- detect screen & AD Tag function --> 

 <!-- Check if the device is a mobile device --> 
function isMobileDevice() {
      return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}
