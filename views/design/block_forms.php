<?php
use system\web\Language;

?>
<div class="design-editor design-block-editor">
	<div class="design-editor-title"></div>
	<div style="margin: 15px 0">
		<div><strong><?= Language::t("common", "Внешние отступы") ?></strong></div>
		<div class="design-slider-container">
			↓ <input type="text" class="design-slider-value design-margin-top-value"> px
			<div class="design-slider design-margin-top-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		&nbsp;
		<div class="design-slider-container">
			← <input type="text" class="design-slider-value design-margin-right-value"> px
			<div class="design-slider design-margin-right-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		&nbsp;
		<div class="design-slider-container">
			↑ <input type="text" class="design-slider-value design-margin-bottom-value"> px
			<div class="design-slider design-margin-bottom-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		&nbsp;
		<div class="design-slider-container">
			→ <input type="text" class="design-slider-value design-margin-left-value"> px
			<div class="design-slider design-margin-left-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
	</div>
	<div style="margin: 15px 0">
		<div><strong><?= Language::t("common", "Внутренние отступы") ?></strong></div>
		<div class="design-slider-container">
			↓ <input type="text" class="design-slider-value design-padding-top-value"> px
			<div class="design-slider design-padding-top-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		&nbsp;
		<div class="design-slider-container">
			← <input type="text" class="design-slider-value design-padding-right-value"> px
			<div class="design-slider design-padding-right-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		&nbsp;
		<div class="design-slider-container">
			↑ <input type="text" class="design-slider-value design-padding-bottom-value"> px
			<div class="design-slider design-padding-bottom-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		&nbsp;
		<div class="design-slider-container">
			→ <input type="text" class="design-slider-value design-padding-left-value"> px
			<div class="design-slider design-padding-left-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
	</div>
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
</div>