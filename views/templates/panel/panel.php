<?php
use system\web\Language;
?>

<div class="j-panel l-panel">
	<a href="#" class="j-close l-close"></a>
	<div class="j-header l-header l-hide">
		<a href="#" class="j-back l-back l-hide">←</a>
		<div class="j-title l-title"></div>
		<div class="j-description l-description"></div>
		<a href="#" class="j-duplicate l-hide"><?= Language::t("common", "Duplicate") ?></a>
		<a href="#" class="j-delete l-hide"><?= Language::t("common", "Delete") ?></a>
	</div>
	<form class="j-panel-form" action="" method="post">
		<div class="j-container l-container"></div>
		<div class="j-footer l-footer l-hide"></div>
	</form>
</div>

<div class="j-panel-item">
	<span class="j-icon l-icon"></span>
	<div class="j-label"></div>
	<a href="#" class="j-design l-design l-hide"><span></span></a>
	<a href="#" class="j-settings l-design l-hide"><span></span></a>
</div>