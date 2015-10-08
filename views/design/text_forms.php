<?php
use system\web\Language;
use models\DesignTextModel;

?>

<div class="design-editor design-text-editor">
	<div class="design-block-container">
		<div class="design-block-content">
			<div class="design-slider-result"><span class="size-result"></span> px</div>
			<div class="design-slider size-slider"></div>
			<input type="hidden" class="size-value">
		</div>
		<div class="design-block-label"><?= Language::t("common", "Размер"); ?></div>
	</div>
	<div class="design-block-container">
		<div class="design-block-content">
			<select class="font-selector">
				<?php foreach (DesignTextModel::$familyList as $key => $value) { ?>
					<option value="<?= $key ?>" class="<?= $value["class"] ?>"><?= $value["name"] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="design-block-label"><?= Language::t("common", "Шрифт"); ?></div>
	</div>
	<div class="design-block-container">
		<div class="design-block-content"><input class="color-picker color-pick"></div>
		<div class="design-block-label"><?= Language::t("common", "Цвет"); ?></div>
	</div>
	<div class="design-block-container">
		<div class="design-block-content">
			<div class="design-slider-result"><span class="letter-spacing-result"></span> px</div>
			<div class="design-slider letter-spacing-slider"></div>
			<input type="hidden" class="letter-spacing-value">
		</div>
		<div class="design-block-label"><?= Language::t("common", "Расстояние между буквами"); ?></div>
	</div>
	<div class="design-block-container">
		<div class="design-block-content">
			<div class="design-slider-result"><span class="line-height-result"></span> %</div>
			<div class="design-slider line-height-slider"></div>
			<input type="hidden" class="line-height-value">
		</div>
		<div class="design-block-label"><?= Language::t("common", "Расстояние между строками"); ?></div>
	</div>
	<div class="design-block-container">
		<div class="design-block-content">
			<div>
				<input type="checkbox" class="is-bold"/>
				<label>Жирный</label>
			</div>
			<div>
				<input type="checkbox" class="is-italic"/>
				<label>Курсив</label>
			</div>
		</div>
		<div class="design-block-label"><?= Language::t("common", "Стили"); ?></div>
	</div>
</div>