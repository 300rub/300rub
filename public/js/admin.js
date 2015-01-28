$(document).ready(function () {

	//$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	$(window).resize(function () {
		//$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	});



	$("#panel-buttons a").on("click", function () {
		$("#panel-buttons a").removeClass("panel-button-half").removeClass("panel-button-active");
		$("#panel-buttons #sections-button").attr("class", "");
		$ajaxWrapper.find(".panel").remove();
		$(this).addClass("panel-button-active");
		(new Panel({
			name: $(this).data("name"),
			title: $(this).find("span").text(),
			content: $(this).data("content"),
			reset: true
		})).init();

		return false;
	});

});