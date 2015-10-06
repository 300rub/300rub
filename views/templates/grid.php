<?php
use system\web\Language;
?>
<div class="grid-stack-line">
	<div class="grid-stack-line-header">
		<div class="title"><?php echo Language::t("common", "Линия"); ?> <span></span></div>
		<a href="#" class="remove">X</a>
	</div>
	<div class="grid-stack"></div>
</div>

<a href="#" class="grid-stack-line-add window-footer-button"><?php echo Language::t(
		"common",
		"Добавить линию"
	); ?></a>

<div class="grid-stack-item">
	<a href="#" class="remove">x</a>

	<div class="grid-stack-item-content"></div>
</div>