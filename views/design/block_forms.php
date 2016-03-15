<?php
use system\web\Language;
use models\DesignBlockModel;
?>
<div class="design-editor design-block-editor">
	<div>
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
	<div>
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
	<div>
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
	<div>
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
					<input type="hidden" class="color-picker color-border-color-picker">
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
	<div>
		<div class="design-group-title"><?= Language::t("common", "Заливка") ?></div>
		<div class="design-line design-line-background">
			<a href="#" class="design-background-clear"><?= Language::t("common", "очистить") ?></a>
			<div class="design-color-picker-container">
				<input type="hidden" class="color-picker color-background-from-picker">
			</div>
			<div class="color-background-arrow">→</div>
			<div class="design-color-picker-container">
				<input type="hidden" class="color-picker color-background-to-picker">
			</div>
		</div>

		<div class="design-line">
			<div class="design-radio-group design-direction-radio-group button-group-container">
				<?php foreach (DesignBlockModel::$gradientDirectionList as $key => $value) { ?>
					<div class="design-radio-container">
						<input
							class="hide design-radio"
							type="radio"
							value="<?= $key ?>"
							data-value="<?= $value["linear"] ?>"
							>
						<label class="design-button-label"><?= $value["label"] ?></label>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>