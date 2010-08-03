(function(win, doc, undefined) {
	var colorInput  = doc.getElementById('color'),
	    alphaInput  = doc.getElementById('alpha'),
	    codeElement = doc.getElementById('code');
	
	var styleSheet = (function() {
		var styleElement = doc.createElement('style');
		doc.getElementsByTagName('head')[0].appendChild(styleElement);
		return doc.styleSheets[doc.styleSheets.length - 1];
	})();
	
	function pad(hexstring) {
		if(hexstring.length == 1) {
			hexstring = '0' + hexstring;
		}
		return hexstring;
	}
	function get_alphahex(alpha, hex) {
		hex = hex.substring(1);
		if(hex.length == 3) {
			hex = hex.charAt(0) + hex.charAt(0)
			    + hex.charAt(1) + hex.charAt(1)
			    + hex.charAt(2) + hex.charAt(2);
		}
		alpha = pad(Math.round(alpha * 255).toString(16));
		return '#' + alpha + hex;
	}
	function get_img_data_url(color, alpha) {
		var canvas = doc.createElement('canvas');
		canvas.width = canvas.height = 1;
		var ctx = canvas.getContext('2d');
		ctx.globalAlpha = alpha;
		ctx.fillStyle = color;
		ctx.fillRect(0, 0, 1, 1);
		return canvas.toDataURL();
	}
	function onchange() {
		var color = colorInput.value,
		    alpha = parseFloat(alphaInput.value, 10);
		
		var alphahex = get_alphahex(alpha, color);
		var code = [
			'*filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=' + alphahex + ', endColorstr=' + alphahex + ')',
			'/* won\'t validate, CSS hack, a method for alpha color backgrounds, http://tinyurl.com/ly6rj2 */'
		];
		try {
			var img_data_url = get_img_data_url(color, alpha);
			code.unshift('background: transparent url(\'' + img_data_url + '\') repeat;');
		} catch(exc) {}
		code = code.join('\n');
		
		codeElement.innerHTML = code;
		try {
			if(styleSheet.deleteRule) {
				styleSheet.deleteRule(0);
			} else {
				styleSheet.removeRule(0);
			}
		} catch(exc) {}
		if(styleSheet.insertRule) {
			styleSheet.insertRule('.halftransparent {' + code + '}', 0);
		} else {
			styleSheet.addRule('.halftransparent', code);
		}
	}
	
	onchange();
	colorInput.onchange = onchange;
	alphaInput.onchange = onchange;
	alphaInput.onkeyup = function() {
		var val = parseFloat(alphaInput.value, 10);
		if(val >= 0 && val <= 1) {
			onchange();
		}
	}
	
	if(window.ColorTriangle) {
		ColorTriangle.initColorInputs({
			size: 200
		});
	} else {
		colorInput.onkeyup = function() {
			if(colorInput.value.match(/^#([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/)) {
				onchange();
			}
		};
	}

})(window, document);
