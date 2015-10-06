<?php
use system\web\Language;
use models\DesignTextModel;
?>

<div class="design-text" style="width: 300px;">
	<div class="design-block-container">
		<div class="design-block-title"><?= Language::t("common", "Размер"); ?></div>
		<div class="size-slider"></div>
		<span class="size-result">20</span> px
		<input type="text" class="size-value" value="20">
		<input type="text" class="size-css">
		<script>
			$(function () {
				$(".size-slider").slider({
					value: 20,
					min: 6,
					max: 100,
					slide: function (event, ui) {
						$(this).parent().find(".size-result").text(ui.value);
						$(this).parent().find(".size-value").val(ui.value);
						$(this).parent().find(".size-css").val("font-size:" + ui.value + "px;");
					}
				});
			});
		</script>
	</div>
	<div class="design-block-container">
		<div class="design-block-title"><?= Language::t("common", "Шрифт"); ?></div>
		<select class="font-selector">
			<?php foreach (DesignTextModel::$familyList as $key => $value) { ?>
				<option value="<?= $key ?>" class="<?= $value["class"] ?>"><?= $value["name"] ?></option>
			<?php } ?>
		</select>
		<script>
			$(function () {
				$(".font-selector").on("change", function () {
					var className = $(this).find(':selected').attr('class');
					$(this).attr("class", "font-selector");
					$(this).addClass(className);
				});
			});
		</script>
	</div>
</div>