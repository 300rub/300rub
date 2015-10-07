<?php
use system\web\Language;
use models\DesignTextModel;
?>

<div class="design-text-editor" style="width: 300px;">
	<div class="design-block-container">
		<div class="design-block-title"><?= Language::t("common", "Размер"); ?></div>
		<div class="size-slider"></div>
		<span class="size-result"></span> px
		<input type="text" class="size-value">
	</div>
	<div class="design-block-container">
		<div class="design-block-title"><?= Language::t("common", "Шрифт"); ?></div>
		<select class="font-selector">
			<?php foreach (DesignTextModel::$familyList as $key => $value) { ?>
				<option value="<?= $key ?>" class="<?= $value["class"] ?>"><?= $value["name"] ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="design-block-container">
		<div class="design-block-title"><?= Language::t("common", "Цвет"); ?></div>
		<input class="color-pick">
	</div>
</div>