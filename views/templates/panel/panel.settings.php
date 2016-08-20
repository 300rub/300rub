<?php
use components\Language;
?>

<a class="j-panel-settings-duplicate l-panel-settings-duplicate">
	<span class="l-icons">
		<i class="j-icon fa fa-files-o"></i>
		<i class="j-loader d-hide fa fa-refresh fa-spin fa-fw"></i>
	</span>
    <span class="j-label"><?= Language::t("common", "duplicate") ?></span>
</a>

<a class="j-panel-settings-delete l-panel-settings-delete">
	<span class="l-icons">
		<i class="j-icon fa fa-trash-o"></i>
		<i class="j-loader d-hide fa fa-refresh fa-spin fa-fw"></i>
	</span>
    <span class="j-label"><?= Language::t("common", "delete") ?></span>
</a>