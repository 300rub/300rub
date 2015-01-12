var Validator = function (form) {

	var t = this;
	this.form = form;
	this.errors = [];

	this.validate = function () {
		this.form.find(".validate").each(function (i) {
			var method = $(this).data("validate");
			t[method]($(this));
		});

		return false;
	};

	this.required = function (form) {
		if ($.trim(form.val() === "")) {
			console.log(123);
		}
	};

};