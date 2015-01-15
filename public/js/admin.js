$(document).ready(function () {

	//$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	$(window).resize(function () {
		//$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	});

	$("#sections-button").on("click", function () {
		(new Panel({
			name: "sections",
			title: $(this).data("title"),
			content: "section/panelList"
		})).init();

		return false;
	});

});