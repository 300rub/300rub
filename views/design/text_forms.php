<?php
use system\web\Language;
use models\DesignTextModel;
?>

<div class="j-design-editor-text">
	<div>
		<div>
			<select class="j-font-family" title="font-family">
				<?php foreach (DesignTextModel::$familyList as $key => $value) { ?>
					<option
						value="<?= $key ?>"
						class="<?= $value["class"] ?>"
					><?= $value["name"] ?></option>
				<?php } ?>
			</select>
			<span></span>
		</div>

		<div class="j-font-size-container">
			<label></label>
			<input type="text" title="font-style">
			<span></span>
		</div>

		<div class="j-font-weight-container">
			<input type="checkbox" class="l-hide j-checkbox" title="font-weight" />
			<label><strong>B</strong></label>
			<input type="hidden" class="j-value">
		</div>

		<div class="j-font-style-container">
			<input type="checkbox" class="l-hide j-checkbox" title="font-style" />
			<label><i>I</i></label>
			<input type="hidden" class="j-value">
		</div>

		<div>
			<input type="hidden" class="j-color" title="color">
		</div>

		<div>
			<?php foreach (DesignTextModel::$textAlignList as $key => $value) { ?>
				<div class="j-radio-container">
					<input
						class="l-hide j-text-align"
						type="radio"
						value="<?= $key ?>"
						data-value="<?= $value ?>"
						title="text-align"
						>
					<label><?= $value ?></label>
				</div>
			<?php } ?>
		</div>

		<div>
			<?php foreach (DesignTextModel::$textTransformList as $key => $value) { ?>
				<div class="j-radio-container">
					<input
						class="l-hide j-text-transform"
						type="radio"
						value="<?= $key ?>"
						data-value="<?= $value ?>"
						title="text-transform"
						>
					<label><?= $value ?></label>
				</div>
			<?php } ?>
		</div>

		<div>
			<?php foreach (DesignTextModel::$textDecorationList as $key => $value) { ?>
				<div class="j-radio-container">
					<input
						class="l-hide j-text-decoration"
						type="radio"
						value="<?= $key ?>"
						data-value="<?= $value ?>"
						title="text-decoration"
						>
					<label><?= $value ?></label>
				</div>
			<?php } ?>
		</div>

		<div class="j-letter-spacing-container">
			<label></label>
			<input type="text" title="letter-spacing">
			<span></span>
		</div>

		<div class="j-line-height-container">
			<label></label>
			<input type="text" title="line-height">
			<span></span>
		</div>
	</div>
</div>