<?php
use system\web\Language;
?>
<div class="grid-stack-line">
	<div class="grid-stack-line-header">
		<div class="title">
			<?= Language::t("common", "Линия"); ?> <span></span>
			<select class="grid-stack-line-select-block">
				<option value="0" data-id="0" data-type="0"><?php echo Language::t("common", "добавить блок"); ?></option>
			</select>
		</div>
		<a href="#" class="remove"><?= Language::t("common", "Удалить"); ?></a>
	</div>
	<div class="grid-stack"></div>
</div>

<a href="#" class="grid-stack-line-add footer-button"><?= Language::t(
		"common",
		"Добавить линию"
	); ?></a>

<div class="grid-stack-item">
	<a href="#" class="remove">x</a>

	<div class="grid-stack-item-content"></div>
</div>