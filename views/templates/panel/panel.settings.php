<?php
use components\Language;
?>

<a class="j-panel-settings-duplicate l-panel-settings-duplicate">
	<i class="l-icon j-icon fa fa-files-o"></i>
    <span class="j-label"><?= Language::t("common", "duplicate") ?></span>
</a>

<a class="j-panel-settings-delete l-panel-settings-delete">
	<span class="l-icons">
		<i class="j-icon fa fa-trash-o"></i>
		<i class="j-loader d-hide fa fa-refresh fa-spin fa-fw"></i>
	</span>
    <span class="j-label"><?= Language::t("common", "delete") ?></span>
</a>

<div class="j-panel-settings-delete-confirmation l-delete-confirmation">
	<div class="l-text"><?= Language::t("common", "deleteConfirmation") ?></div>
	<div class="l-buttons">
		<a class="l-delete j-delete">
			<span class="l-icons">
				<i class="j-icon fa fa-trash-o"></i>
				<i class="j-loader d-hide fa fa-refresh fa-spin fa-fw"></i>
			</span>
			<?= Language::t("common", "delete") ?>
		</a>
		<a class="l-cancel j-cancel">
			<i class="l-icon fa fa-ban"></i>
			<?= Language::t("common", "cancel") ?>
		</a>
	</div>
</div>