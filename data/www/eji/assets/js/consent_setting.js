window.addEventListener("load", function(){

function isWebview() {
    var useragent = navigator.userAgent;
    var rules = ['WebView','(iPhone|iPod|iPad)(?!.*Safari\/)','Android.*(wv|\.0\.0\.0)'];
    var regex = new RegExp(`(${rules.join('|')})`, 'ig');
    return Boolean(useragent.match(regex));
}

if (!isWebview()) {
	window.cookieconsent.initialise({
	  "palette": {
	    "popup": {
	      "background": "#000000"
	    },
	    "button": {
	      "background": "#a3a2a2"
	    }
	  },
	  "position": "top",
	  "static": true,
	  "cookie": {
		  "domain" : ".hkej.com",
		  "expiryDays" : 180
	  },
	  "content": {
		"message": "Hong Kong Economic Journal websites place cookies on your device to give you the best user experience. By using our websites, you agree to the placement of these cookies. To learn more, read our ",
		"dismiss": "X",
		"link": "Privacy Policy",
		"href": "http://www2.hkej.com/info/privacy"
	  }
	})
}
});
