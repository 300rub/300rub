$(document).ready(function () {

	$wrapper = $("#wrapper");
	$ajaxWrapper = $("#ajax-wrapper");
	$templates = $("#templates");
	$loader = $templates.find(".loader");
	$forms = $("#forms");
	$errors = $("#errors");

	if (!IS_MOBILE === true) {
		setWindow();
		$(window).resize(function () {
			setWindow();
		});
	}

	$("#login-button").on("click", function () {
		(new Window({
			name: $(this).data("name"),
			title: $(this).data("title"),
			button: $(this).data("button"),
			forms: $(this).data("forms"),
			send: $(this).data("send")
		})).init();
		return false;
	});

	$("#logout-button").on("click", function () {
		$.ajax({
			url: "/ajax/" + LANG + "/user/logout/",
			success: function () {
				window.location.replace("");
			}
		});

		return false;
	});

});