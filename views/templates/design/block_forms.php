<?php
use components\Language;
use models\DesignBlockModel;
?>

<div class="j-design-editor-block">
	<div>
		<div class="j-title"><?= Language::t("design", "margin") ?></div>
		<div
			class="j-margin-container"
			data-min="<?= DesignBlockModel::MIN_MARGIN_VALUE ?>"
			data-result="j-result"
			>
			<div class="j-top-left">
				<input type="text" data-css="margin-top" title="margin-top">px
			</div>
			<div class="j-bottom-left">
				<input type="text" data-css="margin-left" title="margin-left">px
			</div>
			<div class="j-top-right">
				<input type="text" data-css="margin-right" title="margin-right">px
			</div>
			<div class="j-bottom-right">
				<input type="text" data-css="margin-bottom" title="margin-bottom">px
			</div>

			<div class="j-result-wrapper">
				<div class="j-container">
					<div class="j-result"></div>
				</div>
			</div>

			<label><input type="checkbox"><?= Language::t("design", "combine") ?></label>
		</div>
	</div>

	<div>
		<div><?= Language::t("design", "padding") ?></div>
		<div
			class="j-padding-container"
			data-min="<?= DesignBlockModel::MIN_PADDING_VALUE ?>"
			data-result="j-container"
			>
			<div class="j-top-left">
				<input type="text" data-css="padding-top" title="padding-top">px
			</div>
			<div class="j-bottom-left">
				<input type="text" data-css="padding-left" title="padding-left">px
			</div>
			<div class="j-top-right">
				<input type="text" data-css="padding-right" title="padding-right">px
			</div>
			<div class="j-bottom-right">
				<input type="text" data-css="padding-bottom" title="padding-bottom">px
			</div>

			<div class="j-result-wrapper">
				<div class="j-container">
					<div class="j-result"></div>
				</div>
			</div>

			<label><input type="checkbox"><?= Language::t("design", "combine") ?></label>
		</div>
	</div>

	<div>
		<div><?= Language::t("design", "borderRadius") ?></div>
		<div
			class="j-border-radius-container"
			data-min="<?= DesignBlockModel::MIN_BORDER_RADIUS_VALUE ?>"
			data-result="j-result"
			>
			<div class="j-top-left">
				<input type="text" data-css="border-top-left-radius" title="border-top-left-radius">px
			</div>
			<div class="j-bottom-left">
				<input type="text" data-css="border-bottom-left-radius" title="border-bottom-left-radius">px
			</div>
			<div class="j-top-right">
				<input type="text" data-css="border-top-right-radius" title="border-top-right-radius">px
			</div>
			<div class="j-bottom-right">
				<input type="text" data-css="border-bottom-right-radius" title="border-bottom-right-radius">px
			</div>

			<div class="j-result-wrapper">
				<div class="j-container">
					<div class="j-result"></div>
				</div>
			</div>

			<label><input type="checkbox"><?= Language::t("design", "combine") ?></label>
		</div>
	</div>

	<div>
		<div><?= Language::t("design", "border") ?></div>
		<div
			class="j-border-width-container"
			data-min="<?= DesignBlockModel::MIN_BORDER_WIDTH_VALUE ?>"
			data-result="j-result"
			>
			<div class="j-top-left">
				<input type="text" data-css="border-top-width" title="border-top-width">px
			</div>
			<div class="j-bottom-left">
				<input type="text" data-css="border-left-width" title="border-left-width">px
			</div>
			<div class="j-top-right">
				<input type="text" data-css="border-right-width" title="border-right-width">px
			</div>
			<div class="j-bottom-right">
				<input type="text" data-css="border-bottom-width" title="border-bottom-width">px
			</div>

			<div class="j-result-wrapper">
				<div class="j-container">
					<div class="j-result"></div>
				</div>
			</div>

			<label><input type="checkbox"><?= Language::t("design", "combine") ?></label>

			<div>
				<input type="hidden" class="j-border-color">
			</div>

			<div>
				<?php foreach (DesignBlockModel::$borderStyleList as $key => $value) { ?>
					<div class="j-radio-container">
						<input
							class="j-hide j-border-style"
							type="radio"
							value="<?= $key ?>"
							data-value="<?= $value ?>"
							title="border-style"
							>
						<label><?= $value ?></label>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div>
		<div><?= Language::t("design", "fill") ?></div>
		<div>
			<a href="#" class="j-background-clear"><?= Language::t("design", "clear") ?></a>
			<div>
				<input type="hidden" class="j-background-from">
			</div>
			<div class="color-background-arrow">→</div>
			<div>
				<input type="hidden" class="j-background-to">
			</div>
		</div>

		<div>
			<?php foreach (DesignBlockModel::$gradientDirectionList as $key => $value) { ?>
				<div class="j-radio-container">
					<input
						class="j-hide j-gradient-direction"
						type="radio"
						value="<?= $key ?>"
						data-value="<?= $value["linear"] ?>"
						title="<?= Language::t("design", "gradient") ?>"
						>
					<label><?= $value["label"] ?></label>
				</div>
			<?php } ?>
		</div>
	</div>
</div>