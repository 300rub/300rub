<?php

use system\web\Language;

$uniqueId = uniqid();
?>
<div class="j-window-login-container">
	<div>
		<label for="login-<?= $uniqueId ?>"><?= Language::t("common", "Login") ?></label>
		<input id="login-<?= $uniqueId ?>" type="text"/>
	</div>
	<div>
		<label for="password-<?= $uniqueId ?>"><?= Language::t("common", "Password") ?></label>
		<input id="password-<?= $uniqueId ?>" type="password"/>
	</div>
</div>