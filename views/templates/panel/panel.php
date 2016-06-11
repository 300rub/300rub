<?php 
use components\Language;
?>
<div class="j-panel l-panel">
	<a class="j-close l-close fa fa-close"></a>
	<div class="j-header l-header j-hide">
		<a class="j-back l-back j-hide fa fa-mail-reply"></a>
		<span class="j-title l-title"></span>
		<div class="j-description l-description"></div>
	</div>
	<form class="j-panel-form" action="" method="post">
		<div class="j-container l-container">
			<i class="j-loader l-loader j-hide fa fa-circle-o-notch fa-spin fa-fw"></i>
		</div>
		<div class="j-footer l-footer j-hide"></div>
	</form>
</div>

<a class="j-panel-submit l-panel-submit">
	<span class="j-label"><?= Language::t("common", "save") ?></span>
	<span class="l-icons">
		<i class="j-icon fa fa-check"></i>
		<i class="j-loader j-hide fa fa-refresh fa-spin fa-fw"></i>
	</span>
</a>