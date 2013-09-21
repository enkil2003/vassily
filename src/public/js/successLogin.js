/**
 * 
 */
$(document).ready(function() {
	function parseQuery ( query ) {
		var Params = new Object ();
		if ( ! query ) return Params; // return empty object
		var Pairs = query.split(/[;&]/);
		for ( var i = 0; i < Pairs.length; i++ ) {
			var KeyVal = Pairs[i].split('=');
			if ( ! KeyVal || KeyVal.length != 2 ) continue;
			var key = unescape( KeyVal[0] );
			var val = unescape( KeyVal[1] );
			val = val.replace(/\+/g, ' ');
			Params[key] = val;
		}
		return Params;
	}
	var src = $('#successLogin').attr('src');
	var queryString = src.replace(/^[^\?]+\??/,'');
	alert(queryString);
	var params = parseQuery( queryString );
//	for(i in params) {
//		alert(i);
//		//alert(params[String(i)]);
////		console.log(params[i]);
//	}
	console.log(params.toString());
//	var form = $('<form></form>').attr('id', 'afterSuccessfulLogin');
//	form.
	
});
