$(document).ready(function () {

	$panelButtons = $("#panel-buttons");

	$panelButtons.find("a").on("click", function () {
		var panel = new Panel({
			name: $(this).data("name"),
			title: $(this).find("span").text(),
			content: $(this).data("content")
		});
		panel.close();
		panel.init();
		$(this).addClass("panel-button-active");

		return false;
	});

});