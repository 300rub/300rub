<?php
use components\Language;
?>
<div class="l-window j-window">
	<form class="j-window-form" method="post">
		<a href="#" class="l-close j-close"></a>

		<div class="l-header j-header j-hide"></div>
		<div class="l-container j-container">
			<div class="j-loader j-hide">
				Loading
			</div>
		</div>
		<div class="l-footer j-footer j-hide">
			<a class="j-submit l-submit" href="#">
				<span class="j-label"><?= Language::t("common", "save") ?></span>
				<div class="j-loader j-hide">
					Loading
				</div>
			</a>
		</div>
	</form>
</div>

<div class="l-overlay j-overlay"></div>