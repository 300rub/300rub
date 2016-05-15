<?php 
use components\Language;
?>
<div class="j-panel l-panel">
	<a href="#" class="j-close l-close fa fa-close"></a>
	<div class="j-header l-header j-hide">
		<a href="#" class="j-back l-back j-hide fa fa-mail-reply"></a>
		<span class="j-title l-title"></span>
		<div class="j-description l-description"></div>
	</div>
	<form class="j-panel-form" action="" method="post">
		<div class="j-container l-container">
			<i class="j-loader l-loader j-hide fa fa-spinner fa-pulse fa-2x fa-fw"></i>
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