!function ($) {

	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function(i, v) {
			o[v.name] = v.value || '';
		});
		return o;
	};

	String.prototype.nameToClass = function(withoutDot) {
		var prefix = ".";
		if (withoutDot === true) {
			prefix = "";
		}

		return prefix + "j-" + this.replace(".", "__");
	};

}(window.jQuery);