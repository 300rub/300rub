function setLayout() {
	$(".window .container").css("max-height", parseInt($(document).height()) - 130);
}

$(document).ready(function () {

	$wrapper = $("#wrapper");
	$ajaxWrapper = $("#ajax-wrapper");
	$templates = $("#templates");
	$loader = $templates.find(".loader");
	$forms = $("#forms");
	$errors = $("#errors");

	setLayout();
	$(window).resize(function () {
		setLayout();
	});

	$("#login-button").on("click", function () {
		(new Window("user/form")).init();
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