$(document).ready(function () {

	//$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	$(window).resize(function () {
		//$(".window .container").css("max-height", parseInt($(document).height()) - 130);
	});

	$("#sections-button").on("click", function () {
		$(this).addClass("panel-button-active");
		(new Panel({
			name: "sections",
			title: $(this).find("span").text(),
			content: "section/panelList"
		})).init();

		return false;
	});

	$("#blocks-button").on("click", function () {
		$(this).addClass("panel-button-active");
		(new Panel({
			name: "blocks",
			title: $(this).find("span").text(),
			content: "block/panelList"
		})).init();

		return false;
	});

});