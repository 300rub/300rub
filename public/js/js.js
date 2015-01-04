var Window = function(params) {
	var t = this;
	this.class = params.name;
	this.prev = null;
	this.window = null;

	this.init = function () {
		this.window = $templates.find(".window").clone();
		this.window.addClass("window-" + this.class);
		this.window.appendTo($ajaxWrapper);

		this[this.class]();

		if (this.prev === null) {
			this.showOverlay();
		}

		this.window.find(".close").bind("click", this.close);
		$ajaxWrapper.find(".overlay").bind("click", this.close);
		this.window.find("button").bind("click", this.submit);
	};

	this.showOverlay = function () {
		$templates.find(".overlay").clone().appendTo($ajaxWrapper);
	};

	this.hideOverlay = function () {
		$ajaxWrapper.find(".overlay").remove();
	};

	this.close = function () {
		t.window.remove();
		if (t.prev === null) {
			t.hideOverlay();
		}
		return false;
	};

	this.submit = function () {
		var $form = $(this).parents("form");

		$.ajax({
			url: $form.attr("action"),
			type: "post",
			data: $form.serialize(),
			dataType: "json",
			beforeSend: function(data) {
				$form.find(".error").text("");
			},
			success: function(data) {
				if (data.success === false) {
					$.each(data.errors, function(name, errors) {
						var errs = [];
						$.each(errors, function(type, value) {
							errs[errs.length] = value;
						});
						$form.find("." + name.replace("." ,"__") + " .error").html(errs.join('<br />'));
					});
				}
			}
		});

		return false;
	};
};

Window.prototype.login = function() {
	var $window = this.window;
	var url = "/ajax/" + LANG + "/user/form/";

	$.ajax({
		url: url,
		dataType: "json",
		success: function(data) {
			$window.find(".title").text(data.title);
			$window.find("button").text(data.button);
			$window.find("form").attr("action", "/ajax/" + LANG + "/user/login/");

			var $container = $window.find(".container");

			$.each(data.forms, function(i, params) {
				(new Form(params)).get().appendTo($container);
			});
		}
	});
};

var Form = function(params) {
	var t = this;
	this.params = params;
	this.id = Math.floor(Math.random() * 99999);

	this.get = function () {
		return this[this.params.form]();
	};

	this.input = function () {
		var $object = $forms.find(".input").clone();
		var $form = $object.find("input");

		$form.attr("id", this.id);
		$form.attr("name", t.getName(params.name));
		$object.addClass(t.getClass(params.name));

		$.each(params.attributes, function(attribute, value) {
			$form.attr(attribute, value);
		});

		if (params.label == undefined) {
			$object.find("label").remove();
		} else {
			$object.find("label").text(params.label).attr("for", this.id);
		}

		return $object;
	};

	this.getName = function (name) {
		return "Data[" + name + "]";
	};

	this.getClass = function (name) {
		return name.replace("." ,"__");
	};
};

$(document).ready(function () {

	$templates = $("#templates");
	$ajaxWrapper = $("#ajax-wrapper");
	$forms = $("#forms");

	$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	$(window).resize(function () {
		$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	});

	$("#login-button").on("click", function() {
		(new Window({name: 'login'})).init();
		return false;
	});

});