<?php

use system\web\Language;

$uniqueId = uniqid();
?>
<div class="j-window-login-container">
	<div>
		<label><?= Language::t("common", "Login") ?></label>
		<input type="text"/>
	</div>
	<div>
		<label><?= Language::t("common", "Password") ?></label>
		<input type="password"/>
	</div>
</div>