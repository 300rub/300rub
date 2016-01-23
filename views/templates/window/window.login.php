<?php

use system\web\Language;

$uniqueId = uniqid();
?>
<div class="j-window-login-container">
	<div>
		<label><?= Language::t("common", "Login") ?></label>
		<input class="j-t__login j-validate" type="text"/>
	</div>
	<div>
		<label><?= Language::t("common", "Password") ?></label>
		<input class="j-t__password j-validate" type="password"/>
	</div>
</div>