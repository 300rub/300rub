<?php
use system\web\Language;
?>
<div class="l-window j-window">
	<form>
		<a href="#" class="l-close j-close"></a>

		<div class="l-header j-header"></div>
		<div class="l-container j-container"></div>
		<div class="l-footer j-footer">
			<button class="j-submit"><span><?= Language::t("common", "Save") ?></span></button>
		</div>
	</form>
</div>

<div class="l-overlay j-overlay"></div>