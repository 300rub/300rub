<?php
use system\web\Language;
use models\DesignTextModel;

?>

<div class="design-editor design-text-editor">
	<div class="design-group-container">
		<div class="design-line">
			<div class="design-selector-container">
				<select class="design-font-selector design-selector">
					<?php foreach (DesignTextModel::$familyList as $key => $value) { ?>
						<option value="<?= $key ?>" class="<?= $value["class"] ?>"><?= $value["name"] ?></option>
					<?php } ?>
				</select>
				<span></span>
			</div>
		</div>
		<div class="design-line">
			<div class="design-spinner-container design-spinner-font-size-container">
				<label></label>
				<input type="text">
				<span></span>
			</div>
			<div class="design-bold-italic-container">
				<div class="button-group-container">
					<div class="design-checkbox-container">
						<input type="checkbox" class="hide design-checkbox design-font-weight-checkbox"/>
						<label class="design-button-label"><strong>B</strong></label>
						<input type="hidden" class="design-checkbox-value">
					</div>
				</div>
				<div class="button-group-container">
					<div class="design-checkbox-container">
						<input type="checkbox" class="hide design-checkbox design-font-style-checkbox"/>
						<label class="design-button-label"><i>I</i></label>
						<input type="hidden" class="design-checkbox-value">
					</div>
				</div>
			</div>
		</div>

		<div class="design-line design-line-align-color">
			<div class="design-color-picker-container design-color-picker-color-container">
				<input type="hidden" class="color-picker color-color-picker">
			</div>

			<div class="design-radio-group design-text-align-radio-group button-group-container">
				<?php foreach (DesignTextModel::$textAlignList as $key => $value) { ?>
					<div class="design-radio-container">
						<input
							class="hide design-radio"
							type="radio"
							value="<?= $key ?>"
							data-value="<?= $value ?>"
							>
						<label class="design-button-label design-text-align-<?= $value ?>"><span></span></label>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="design-line">
			<div class="design-radio-group design-text-transform-radio-group button-group-container">
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
			<div class="design-radio-group design-text-decoration-radio-group button-group-container">
				<?php foreach (DesignTextModel::$textDecorationList as $key => $value) { ?>
					<div class="design-radio-container">
						<input
							class="hide design-radio"
							type="radio"
							value="<?= $key ?>"
							data-value="<?= $value["value"] ?>"
							>
						<label class="design-button-label"
							   style="text-decoration: <?= $value["value"] ?>;"><?= $value["label"] ?></label>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="design-line">
			<div class="design-spinner-container design-spinner-letter-spacing-container">
				<label></label>
				<input type="text">
				<span></span>
			</div>
			<div class="design-spinner-container design-spinner-line-height-container">
				<label></label>
				<input type="text">
				<span></span>
			</div>
		</div>
	</div>
</div>