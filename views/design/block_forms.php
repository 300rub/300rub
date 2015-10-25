<?php
use system\web\Language;
use models\DesignBlockModel;
?>
<div class="design-editor design-block-editor">
	<div class="design-group-container">
		<div class="design-group-title"><?= Language::t("common", "Внешние отступы") ?></div>
		<div
			class="design-angles-container design-angles-margin-container"
			data-min="-300"
			data-result="design-angles-result"
			>
			<div class="design-angles-top-left"><input type="text" data-css="margin-top">px</div>
			<div class="design-angles-bottom-left"><input type="text" data-css="margin-left">px</div>
			<div class="design-angles-top-right"><input type="text" data-css="margin-right">px</div>
			<div class="design-angles-bottom-right"><input type="text" data-css="margin-bottom">px</div>
			<div class="design-angles-result-wrapper">
				<div class="design-angles-result-container">
					<div class="design-angles-result"></div>
				</div>
			</div>
			<label><input type="checkbox"> <?= Language::t("common", "Соединить") ?></label>
		</div>
	</div>
	<div class="design-group-container">
		<div class="design-group-title"><?= Language::t("common", "Внутренние отступы") ?></div>
		<div
			class="design-angles-container design-angles-padding-container"
			data-min="0"
			data-result="design-angles-result-container"
			>
			<div class="design-angles-top-left"><input type="text" data-css="padding-top">px</div>
			<div class="design-angles-bottom-left"><input type="text" data-css="padding-left">px</div>
			<div class="design-angles-top-right"><input type="text" data-css="padding-right">px</div>
			<div class="design-angles-bottom-right"><input type="text" data-css="padding-bottom">px</div>
			<div class="design-angles-result-wrapper">
				<div class="design-angles-result-container">
					<div class="design-angles-result"></div>
				</div>
			</div>
			<label><input type="checkbox"> <?= Language::t("common", "Соединить") ?></label>
		</div>
	</div>
	<div class="design-group-container">
		<div class="design-group-title"><?= Language::t("common", "Скругления углов") ?></div>
		<div
			class="design-angles-container design-angles-border-radius-container"
			data-min="0"
			data-result="design-angles-result"
			>
			<div class="design-angles-top-left"><input type="text" data-css="border-top-left-radius">px</div>
			<div class="design-angles-bottom-left"><input type="text" data-css="border-bottom-left-radius">px</div>
			<div class="design-angles-top-right"><input type="text" data-css="border-top-right-radius">px</div>
			<div class="design-angles-bottom-right"><input type="text" data-css="border-bottom-right-radius">px</div>
			<div class="design-angles-result-wrapper">
				<div class="design-angles-result-container">
					<div class="design-angles-result"></div>
				</div>
			</div>
			<label><input type="checkbox"> <?= Language::t("common", "Соединить") ?></label>
		</div>
	</div>
	<div class="design-group-container">
		<div class="design-group-title"><?= Language::t("common", "Граница") ?></div>
		<div
			class="design-angles-container design-angles-border-container"
			data-min="0"
			data-result="design-angles-result"
			>
			<div class="design-angles-top-left"><input type="text" data-css="border-top-width">px</div>
			<div class="design-angles-bottom-left"><input type="text" data-css="border-left-width">px</div>
			<div class="design-angles-top-right"><input type="text" data-css="border-right-width">px</div>
			<div class="design-angles-bottom-right"><input type="text" data-css="border-bottom-width">px</div>
			<div class="design-angles-result-wrapper">
				<div class="design-angles-result-container">
					<div class="design-angles-result"></div>
				</div>
			</div>
			<label><input type="checkbox"> <?= Language::t("common", "Соединить") ?></label>
			<div class="design-line design-line-border-style-color">
				<div class="design-color-picker-container design-color-picker-color-container">
					<input type="hidden" class="color-picker color-color-picker">
				</div>

				<div class="design-radio-group design-border-style-radio-group button-group-container">
					<?php foreach (DesignBlockModel::$borderStyleList as $key => $value) { ?>
						<div class="design-radio-container">
							<input
								class="hide design-radio"
								type="radio"
								value="<?= $key ?>"
								data-value="<?= $value ?>"
								>
							<label class="design-button-label design-border-style-<?= $value ?>"><span></span></label>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--

	<div style="margin: 15px 0">
		<div><strong><?= Language::t("common", "Заливка") ?></strong></div>
		<input class="design-color-gradient color-background-color-picker">
		&nbsp;
		<input class="design-color-gradient color-background-picker">
		<select class="design-gradient-direction">
			<option value="0" data-value="to right"><?= Language::t("common", "горизонтальная") ?>&nbsp;&nbsp;→</option>
			<option value="1" data-value="to bottom"><?= Language::t("common", "вертикальная") ?>&nbsp;&nbsp;↓</option>
			<option value="2" data-value="135deg"><?= Language::t("common", "диагональная") ?>&nbsp;&nbsp;↘</option>
			<option value="3" data-value="45deg"><?= Language::t("common", "диагональная") ?>&nbsp;&nbsp;↗</option>
		</select>
		<a href="#" class="design-background-reset"><?= Language::t("common", "Убрать фон") ?></a>
	</div>
	<div style="margin: 15px 0">
		<div><strong><?= Language::t("common", "Граница") ?></strong></div>
		<div>
			<input class="design-border-color color-border-top-color-picker">
			<div class="design-slider-container">
				<input type="text" class="design-slider-value"> px
				<div class="design-slider design-border-top-width-slider"></div>
				<div class="design-slider-overlay"></div>
			</div>
			<select class="design-border-style design-border-top-style-selector">
				<option value="0" data-value="none"><?= Language::t("common", "отсутствует") ?></option>
				<option value="1" data-value="solid"><?= Language::t("common", "сплошная") ?></option>
				<option value="2" data-value="dotted"><?= Language::t("common", "в точку") ?></option>
				<option value="3" data-value="dashed"><?= Language::t("common", "пунктир") ?></option>
			</select>
			<div class="design-slider-container">
				<input type="text" class="design-slider-value"> px
				<div class="design-slider design-border-top-left-radius-slider"></div>
				<div class="design-slider-overlay"></div>
			</div>
		</div>
		<div>
			<input class="design-border-color color-border-right-color-picker">
			<div class="design-slider-container">
				<input type="text" class="design-slider-value"> px
				<div class="design-slider design-border-right-width-slider"></div>
				<div class="design-slider-overlay"></div>
			</div>
			<select class="design-border-style design-border-right-style-selector">
				<option value="0" data-value="none"><?= Language::t("common", "отсутствует") ?></option>
				<option value="1" data-value="solid"><?= Language::t("common", "сплошная") ?></option>
				<option value="2" data-value="dotted"><?= Language::t("common", "в точку") ?></option>
				<option value="3" data-value="dashed"><?= Language::t("common", "пунктир") ?></option>
			</select>
			<div class="design-slider-container">
				<input type="text" class="design-slider-value"> px
				<div class="design-slider design-border-top-right-radius-slider"></div>
				<div class="design-slider-overlay"></div>
			</div>
		</div>
		<div>
			<input class="design-border-color color-border-bottom-color-picker">
			<div class="design-slider-container">
				<input type="text" class="design-slider-value"> px
				<div class="design-slider design-border-bottom-width-slider"></div>
				<div class="design-slider-overlay"></div>
			</div>
			<select class="design-border-style design-border-bottom-style-selector">
				<option value="0" data-value="none"><?= Language::t("common", "отсутствует") ?></option>
				<option value="1" data-value="solid"><?= Language::t("common", "сплошная") ?></option>
				<option value="2" data-value="dotted"><?= Language::t("common", "в точку") ?></option>
				<option value="3" data-value="dashed"><?= Language::t("common", "пунктир") ?></option>
			</select>
			<div class="design-slider-container">
				<input type="text" class="design-slider-value"> px
				<div class="design-slider design-border-bottom-right-radius-slider"></div>
				<div class="design-slider-overlay"></div>
			</div>
		</div>
		<div>
			<input class="design-border-color color-border-left-color-picker">
			<div class="design-slider-container">
				<input type="text" class="design-slider-value"> px
				<div class="design-slider design-border-left-width-slider"></div>
				<div class="design-slider-overlay"></div>
			</div>
			<select class="design-border-style design-border-left-style-selector">
				<option value="0" data-value="none"><?= Language::t("common", "отсутствует") ?></option>
				<option value="1" data-value="solid"><?= Language::t("common", "сплошная") ?></option>
				<option value="2" data-value="dotted"><?= Language::t("common", "в точку") ?></option>
				<option value="3" data-value="dashed"><?= Language::t("common", "пунктир") ?></option>
			</select>
			<div class="design-slider-container">
				<input type="text" class="design-slider-value"> px
				<div class="design-slider design-border-bottom-left-radius-slider"></div>
				<div class="design-slider-overlay"></div>
			</div>
		</div>
	</div>
	<a href="#" class="design-reset"><?= Language::t("common", "Откатить") ?></a>
	-->
