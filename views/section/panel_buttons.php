<?php
use system\web\Language;
?>

<div id="panel-buttons">
	<a
		href="#"
		id="sections-button"
		data-name="sections"
		data-content="section/panelList"
		><span><?php echo Language::t("common", "Разделы"); ?></span></a>

	<a
		href="#"
		id="blocks-button"
		data-name="blocks"
		data-content="blocks/panelList"
		><span><?php echo Language::t("common", "Блоки"); ?></span></a>

	<a
		href="#"
		id="settings-button"
		data-name="settings"
		data-content="blocks/panelList"
		><span><?php echo Language::t("common", "Настройки"); ?></span></a>

	<a
		href="#"
		id="payment-button"
		data-name="payment"
		data-content="blocks/panelList"
		><span><?php echo Language::t("common", "Оплата"); ?></span></a>
</div>