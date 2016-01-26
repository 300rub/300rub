!function ($) {

	/**
	 * Gets data from form
	 *
	 * @returns {Object}
     */
	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function(i, v) {
			o[v.name] = v.value || '';
		});
		return o;
	};

	/**
	 * Converts name to class
	 *
	 * @param {Boolean} [withoutDot] Without dot
	 *
	 * @returns {String}
     */
	String.prototype.nameToClass = function(withoutDot) {
		var prefix = ".";
		if (withoutDot === true) {
			prefix = "";
		}

		return prefix + "j-" + this.replace(".", "__");
	};

}(window.jQuery);