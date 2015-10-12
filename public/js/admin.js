function setPanelHeight() {
	$(".panel .container").css("max-height", parseInt($(document).height()) - 240);
}

$(document).ready(function () {

	setPanelHeight();
	$(window).resize(function () {
		setPanelHeight();
	});

	$.fn.removeClassByMask = function(mask) {
		return this.removeClass(function(index, cls) {
			var re = mask.replace(/\*/g, '\\S+');
			return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ');
		});
	};

	$panelButtons = $("#panel-buttons");

	$panelButtons.find("a").on("click", function () {
		var panel = new Panel({
			name: $(this).data("name"),
			content: $(this).data("content")
		});
		panel.close();
		panel.init();
		$(this).addClass("panel-button-active");

		return false;
	});

});