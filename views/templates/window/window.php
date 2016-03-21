<?php
use system\web\Language;
?>
<div class="l-window j-window">
	<form class="j-window-form" method="post">
		<a href="#" class="l-close j-close"></a>

		<div class="l-header j-header l-hide"></div>
		<div class="l-container j-container"></div>
		<div class="l-footer j-footer l-hide">
			<button class="j-submit"><span><?= Language::t("common", "save") ?></span></button>
		</div>
	</form>
</div>

<div class="l-overlay j-overlay"></div>