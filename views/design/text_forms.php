<?php
use system\web\Language;
use models\DesignTextModel;

?>

<div class="design-editor design-text-editor">
	<div class="design-editor-title"></div>
	<div style="margin: 15px 0">
		<select class="design-font-selector">
			<?php foreach (DesignTextModel::$familyList as $key => $value) { ?>
				<option value="<?= $key ?>" class="<?= $value["class"] ?>"><?= $value["name"] ?></option>
			<?php } ?>
		</select>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<div class="design-slider-container">
			<input type="text" class="design-slider-value design-font-size-value"> px
			<div class="design-slider design-font-size-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
	</div>
	<div style="margin: 15px 0">
		<div class="design-checkbox-container">
			<input type="checkbox" class="hide design-checkbox design-font-weight-checkbox"/>
			<label class="design-button-label"><strong>B</strong></label>
			<input type="hidden" class="design-checkbox-value">
		</div>
		<div class="design-checkbox-container">
			<input type="checkbox" class="hide design-checkbox design-font-style-checkbox"/>
			<label class="design-button-label"><i>I</i></label>
			<input type="hidden" class="design-checkbox-value">
		</div>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input class="color-picker color-color-picker">
	</div>
	<div style="margin: 15px 0">
		<div class="design-radio-group design-text-align-radio-group">
			<?php foreach (DesignTextModel::$textAlignList as $key => $value) { ?>
				<div class="design-radio-container">
					<input
						class="hide design-radio"
						type="radio"
						value="<?= $key ?>"
						data-value="<?= $value["value"] ?>"
						>
					<label class="design-button-label"><?= $value["label"] ?></label>
				</div>
			<?php } ?>
		</div>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<div class="design-radio-group design-text-transform-radio-group">
			<?php foreach (DesignTextModel::$textTransformList as $key => $value) { ?>
				<div class="design-radio-container">
					<input
						class="hide design-radio"
						type="radio"
						value="<?= $key ?>"
						data-value="<?= $value["value"] ?>"
						>
					<label class="design-button-label"><?= $value["label"] ?></label>
				</div>
			<?php } ?>
		</div>
	</div>
	<div style="margin: 15px 0">
		<div class="design-radio-group design-text-decoration-radio-group">
			<?php foreach (DesignTextModel::$textDecorationList as $key => $value) { ?>
				<div class="design-radio-container">
					<input
						class="hide design-radio"
						type="radio"
						value="<?= $key ?>"
						data-value="<?= $value["value"] ?>"
						>
					<label class="design-button-label"><?= $value["label"] ?></label>
				</div>
			<?php } ?>
		</div>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<div class="design-slider-container">
			<input type="text" class="design-slider-value design-letter-spacing-value"> px
			<div class="design-slider design-letter-spacing-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<div class="design-slider-container">
			<input type="text" class="design-slider-value design-line-height-value"> %
			<div class="design-slider design-line-height-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
	</div>
	<a href="#" class="design-reset"><?= Language::t("common", "Откатить") ?></a>
</div>