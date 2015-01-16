function setLayout() {
	if (IS_MOBILE === true) {
		var zoom = $(document).width() / 320;
		$(".window").css({
			"zoom" : zoom,
			"-ms-zoom" : zoom
		});
	} else {
		$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	}
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