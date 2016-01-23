!function ($) {

	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function(i, v) {
			o[v.name] = v.value || '';
		});
		return o;
	};

	String.prototype.nameToClass = function() {
		var prefix = ".";
		//if (withDot === false) {
		//	prefix = "";
		//}

		return prefix + "j-" + this.replace(".", "__");
	};

}(window.jQuery);