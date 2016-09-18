<?php
use components\Language;
use models\DesignBlockModel;
?>

<div class="j-design-editor-block l-design-editor">
	<div class="l-line">
		<div class="l-title">
			<span class="l-text">
				<?= Language::t("design", "margin") ?>
			</span>
		</div>
		<div
			class="j-margin-container l-angles-container l-margin-container"
			data-min="<?= DesignBlockModel::MIN_MARGIN_VALUE ?>"
			data-result="j-result"
			>
			<div class="j-top-left l-angel-item l-top-left">
				<input class="l-value" type="text" data-css="margin-top" title="margin-top">
				<div class="l-type">px</div>
			</div>
			<div class="j-bottom-left l-angel-item l-bottom-left">
				<input class="l-value" type="text" data-css="margin-left" title="margin-left">
				<div class="l-type">px</div>
			</div>
			<div class="j-top-right l-angel-item l-top-right">
				<input class="l-value" type="text" data-css="margin-right" title="margin-right">
				<div class="l-type">px</div>
			</div>
			<div class="j-bottom-right l-angel-item l-bottom-right">
				<input class="l-value" type="text" data-css="margin-bottom" title="margin-bottom">
				<div class="l-type">px</div>
			</div>

			<div class="j-result-wrapper l-result-wrapper">
				<div class="j-result-container l-result-container">
					<div class="j-result l-result"></div>
				</div>
			</div>

			<div class="l-checkbox-container l-join-container">
				<label class="l-label-container j-join-label">
					<span class="l-body">
						<input class="j-join-value l-checkbox" type="checkbox"/>
						<span class="l-icons">
							<i class="fa fa-square-o"></i>
							<i class="fa fa-check-square-o"></i>
						</span>
						<span class="l-label-text"><?= Language::t("design", "combine") ?></span>
					</span>
				</label>
			</div>
		</div>
	</div>

	<div class="l-line">
		<div class="l-title">
			<span class="l-text">
				<?= Language::t("design", "padding") ?>
			</span>
		</div>
		<div
			class="j-padding-container l-angles-container l-padding-container"
			data-min="<?= DesignBlockModel::MIN_PADDING_VALUE ?>"
			data-result="j-container"
			>
			<div class="j-top-left l-angel-item l-top-left">
				<input class="l-value" type="text" data-css="padding-top" title="padding-top">
				<div class="l-type">px</div>
			</div>
			<div class="j-bottom-left l-angel-item l-bottom-left">
				<input class="l-value" type="text" data-css="padding-left" title="padding-left">
				<div class="l-type">px</div>
			</div>
			<div class="j-top-right l-angel-item l-top-right">
				<input class="l-value" type="text" data-css="padding-right" title="padding-right">
				<div class="l-type">px</div>
			</div>
			<div class="j-bottom-right l-angel-item l-bottom-right">
				<input class="l-value" type="text" data-css="padding-bottom" title="padding-bottom">
				<div class="l-type">px</div>
			</div>

			<div class="j-result-wrapper l-result-wrapper">
				<div class="j-container l-result-container">
					<div class="j-result l-result"></div>
				</div>
			</div>

			<div class="l-checkbox-container l-join-container">
				<label class="l-label-container j-join-label">
					<span class="l-body">
						<input class="j-join-value l-checkbox" type="checkbox"/>
						<span class="l-icons">
							<i class="fa fa-square-o"></i>
							<i class="fa fa-check-square-o"></i>
						</span>
						<span class="l-label-text"><?= Language::t("design", "combine") ?></span>
					</span>
				</label>
			</div>
		</div>
	</div>

	<div class="l-line">
		<div class="l-title">
			<span class="l-text">
				<?= Language::t("design", "borderRadius") ?>
			</span>
		</div>
		<div
			class="j-border-radius-container l-angles-container l-border-radius-container"
			data-min="<?= DesignBlockModel::MIN_BORDER_RADIUS_VALUE ?>"
			data-result="j-result"
			>
			<div class="j-top-left l-angel-item l-top-left">
				<input
					class="l-value"
					type="text"
					data-css="border-top-left-radius"
					title="border-top-left-radius"
				>
				<div class="l-type">px</div>
			</div>
			<div class="j-bottom-left l-angel-item l-bottom-left">
				<input
					class="l-value"
					type="text"
					data-css="border-bottom-left-radius"
					title="border-bottom-left-radius"
				>
				<div class="l-type">px</div>
			</div>
			<div class="j-top-right l-angel-item l-top-right">
				<input
					class="l-value"
					type="text"
					data-css="border-top-right-radius"
					title="border-top-right-radius"
				>
				<div class="l-type">px</div>
			</div>
			<div class="j-bottom-right l-angel-item l-bottom-right">
				<input
					class="l-value"
					type="text"
					data-css="border-bottom-right-radius"
					title="border-bottom-right-radius"
				>
				<div class="l-type">px</div>
			</div>

			<div class="j-result-wrapper l-result-wrapper">
				<div class="j-container l-result-container">
					<div class="j-result l-result"></div>
				</div>
			</div>

			<div class="l-checkbox-container l-join-container">
				<label class="l-label-container j-join-label">
					<span class="l-body">
						<input class="j-join-value l-checkbox" type="checkbox"/>
						<span class="l-icons">
							<i class="fa fa-square-o"></i>
							<i class="fa fa-check-square-o"></i>
						</span>
						<span class="l-label-text"><?= Language::t("design", "combine") ?></span>
					</span>
				</label>
			</div>
		</div>
	</div>

	<div class="l-line">
		<div class="l-title">
			<span class="l-text">
				<?= Language::t("design", "border") ?>
			</span>
		</div>
		<div
			class="j-border-width-container l-angles-container l-border-width-container"
			data-min="<?= DesignBlockModel::MIN_BORDER_WIDTH_VALUE ?>"
			data-result="j-result"
			>
			<div class="j-top-left l-angel-item l-top-left">
				<input class="l-value" type="text" data-css="border-top-width" title="border-top-width">
				<div class="l-type">px</div>
			</div>
			<div class="j-bottom-left l-angel-item l-bottom-left">
				<input class="l-value" type="text" data-css="border-left-width" title="border-left-width">
				<div class="l-type">px</div>
			</div>
			<div class="j-top-right l-angel-item l-top-right">
				<input class="l-value" type="text" data-css="border-right-width" title="border-right-width">
				<div class="l-type">px</div>
			</div>
			<div class="j-bottom-right l-angel-item l-bottom-right">
				<input class="l-value" type="text" data-css="border-bottom-width" title="border-bottom-width">
				<div class="l-type">px</div>
			</div>

			<div class="j-result-wrapper l-result-wrapper">
				<div class="j-container l-result-container">
					<div class="j-result l-result"></div>
				</div>
			</div>

			<div class="l-checkbox-container l-join-container">
				<label class="l-label-container j-join-label">
					<span class="l-body">
						<input class="j-join-value l-checkbox" type="checkbox"/>
						<span class="l-icons">
							<i class="fa fa-square-o"></i>
							<i class="fa fa-check-square-o"></i>
						</span>
						<span class="l-label-text"><?= Language::t("design", "combine") ?></span>
					</span>
				</label>
			</div>

			<div>
				Color: <input type="hidden" class="j-border-color">
			</div>

			<div>
				<?php foreach (DesignBlockModel::$borderStyleList as $key => $value) { ?>
					<div class="j-radio-container l-radio-container">
						<input
							class="d-hide j-border-style"
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

	<div class="l-line">
		<div class="l-title">
			<span class="l-text">
				<?= Language::t("design", "fill") ?>
			</span>
		</div>
		<div>
			<a class="j-background-clear"><?= Language::t("design", "clear") ?></a>
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
				<div class="j-radio-container l-radio-container">
					<input
						class="d-hide j-gradient-direction"
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