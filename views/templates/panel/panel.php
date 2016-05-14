<?php 
use components\Language;
?>
<div class="j-panel l-panel">
	<a href="#" class="j-close l-close fa fa-close"></a>
	<div class="j-header l-header j-hide">
		<a href="#" class="j-back l-back j-hide">←</a>
		<div class="j-title l-title"></div>
		<div class="j-description l-description"></div>
	</div>
	<form class="j-panel-form" action="" method="post">
		<div class="j-container l-container">
			<div class="j-loader j-hide">
				Loading
			</div>
		</div>
		<div class="j-footer l-footer j-hide"></div>
	</form>
</div>

<button class="j-panel-submit">
	<span class="j-label"><?= Language::t("common", "save") ?></span>
	<div class="j-loader j-hide">
		loading
	</div>
</button>