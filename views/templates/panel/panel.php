<?php 
use components\Language;
?>
<div class="j-panel l-panel">
	<a class="j-close l-close fa fa-close"></a>
	<div class="j-header l-header d-hide">
		<div class="l-delete-confirmation">
			<div class="l-buttons">
				<a class="l-delete">
					<i class="l-icon fa fa-trash-o"></i>
					<?= Language::t("common", "delete") ?>
				</a>
				<a class="l-cancel">
					<i class="l-icon fa fa-ban"></i>
					<?= Language::t("common", "cancel") ?>
				</a>
			</div>
		</div>

		<a class="j-back l-back d-hide fa fa-chevron-left"></a>
		<span class="j-title l-title"></span>
		<div class="j-description l-description"></div>
	</div>
	<form class="j-panel-form" action="" method="post">
		<div class="j-container l-container">
			<i class="j-loader l-loader d-hide fa fa-circle-o-notch fa-spin fa-fw"></i>
		</div>
		<div class="j-footer l-footer d-hide"></div>
	</form>
</div>

<a class="j-panel-submit l-panel-submit">
	<span class="j-label"><?= Language::t("common", "save") ?></span>
	<span class="l-icons">
		<i class="j-icon fa fa-check"></i>
		<i class="j-loader d-hide fa fa-refresh fa-spin fa-fw"></i>
	</span>
</a>