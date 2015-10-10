<?php
use system\web\Language;
use models\DesignTextModel;

?>

<div class="design-editor design-text-editor">
	<div class="design-editor-title"></div>
	<div>
		<select class="design-font-selector">
			<?php foreach (DesignTextModel::$familyList as $key => $value) { ?>
				<option value="<?= $key ?>" class="<?= $value["class"] ?>"><?= $value["name"] ?></option>
			<?php } ?>
		</select>

		<div class="design-slider-container">
			<input type="text" class="design-slider-value design-font-size-value"> px
			<div class="design-slider design-font-size-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
	</div>
	<div>
		<div class="design-checkbox-container">
			<input type="checkbox" class="hide design-checkbox design-font-weight-checkbox"/>
			<label class="design-button-label"><strong>B</strong></label>
		</div>
		<div class="design-checkbox-container">
			<input type="checkbox" class="hide design-checkbox design-font-style-checkbox"/>
			<label class="design-button-label"><i>I</i></label>
		</div>
		<input class="color-picker color-color-picker">
	</div>
	<div>
		<div class="design-radio-group design-text-align-radio-group">
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="0" data-value="left">
				<label class="design-button-label">L</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="1" data-value="center">
				<label class="design-button-label">C</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="2" data-value="right">
				<label class="design-button-label">R</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="3" data-value="justify">
				<label class="design-button-label">J</label>
			</div>
		</div>
		<div class="design-radio-group design-text-transform-radio-group">
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="0" data-value="none">
				<label class="design-button-label">Х</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="1" data-value="uppercase">
				<label class="design-button-label">AA</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="2" data-value="lowercase">
				<label class="design-button-label">aa</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="3" data-value="capitalize">
				<label class="design-button-label">Aa</label>
			</div>
		</div>
	</div>
	<div>
		<div class="design-radio-group design-text-decoration-radio-group">
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="0" data-value="none">
				<label class="design-button-label">Х</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="1" data-value="underline">
				<label class="design-button-label">_</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="2" data-value="line-through">
				<label class="design-button-label">-</label>
			</div>
			<div class="design-radio-container">
				<input class="hide design-radio" type="radio" value="3" data-value="overline">
				<label class="design-button-label">``</label>
			</div>
		</div>
		<div class="design-slider-container">
			<input type="text" class="design-slider-value design-letter-spacing-value"> px
			<div class="design-slider design-letter-spacing-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		<div class="design-slider-container">
			<input type="text" class="design-slider-value design-line-height-value"> %
			<div class="design-slider design-line-height-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
	</div>
	<a href="#" class="design-reset"><?= Language::t("common", "Откатить") ?></a>
</div>