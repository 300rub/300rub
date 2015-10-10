<?php
use system\web\Language;
?>
<div class="design-editor design-block-editor">
	<div class="design-editor-title"></div>
	<div>
		<div><?= Language::t("common", "Внешние отступы") ?></div>
		<div class="design-slider-container">
			↓ <input type="text" class="design-slider-value design-margin-top-value"> px
			<div class="design-slider design-margin-top-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		<div class="design-slider-container">
			← <input type="text" class="design-slider-value design-margin-right-value"> px
			<div class="design-slider design-margin-right-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		<div class="design-slider-container">
			↑ <input type="text" class="design-slider-value design-margin-bottom-value"> px
			<div class="design-slider design-margin-bottom-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
		<div class="design-slider-container">
			→ <input type="text" class="design-slider-value design-margin-left-value"> px
			<div class="design-slider design-margin-left-slider"></div>
			<div class="design-slider-overlay"></div>
		</div>
	</div>
</div>