!function ($, c) {
	"use strict";

	c.Validator = function (form) {
		this.$form = form;
		this.validate();
	};

	c.Validator.prototype = {
		errors: {},

		validate: function() {
			this.errors = {};

			var $field, split;
			this.$form.find(".j-validate").each($.proxy(function (i, field) {
				$field = $(field);
				$.each($field.data("rules").split(", "), $.proxy(function (i, rule) {
					split = rule.split("-");
					if (split[1] === undefined) {
						this[split[0]]($field);
					} else {
						this[split[0]]($field, split[1]);
					}
				}, this));
			}, this));

			this.hideErrors();
			if (!$.isEmptyObject(this.errors)) {
				this.showErrors();
				return false;
			}

			return true;
		},

		required: function ($field) {
			if ($.trim($field.val()) === "") {
				this.addError($field.attr("name"), "required");
			}
		},

		max: function ($field, max) {
			if ($.trim($field.val()).length > parseInt(max)) {
				this.addError($field.attr("name"), "max");
			}
		},

		addError: function (key, value) {
			if (this.errors[key] === undefined) {
				this.errors[key] = value;
			}
		},

		hideErrors: function() {
			this.$form.find("div.j-error").remove();
		},

		showErrors: function () {
			$.each(this.errors, $.proxy(function (name, error) {
				this.$form.find(name.nameToClass()).after(c.$templates.find(".j-error-" + error).clone());
			}, this));
		}
	};

	$.validator = function (form) {
		return new c.Validator(form);
	};
}(window.jQuery, window.Core);