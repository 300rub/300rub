<?php
use components\Language;
?>
<div class="j-window-login-container">
	<div>
		<label><?= Language::t("user", "login") ?>
			<input class="j-t__login j-validate l-form" type="text"/>
		</label>
	</div>
	<div>
		<label><?= Language::t("user", "password") ?>
			<input class="j-t__password j-validate l-form" type="password"/>
		</label>
	</div>
	<div class="l-checkbox-container">
		<label>
			<input class="j-t__is_remember" type="checkbox"/>
			<span>
				<i class="fa fa-square-o"></i>
				<i class="fa fa-check-square-o"></i>
			</span>
			<?= Language::t("user", "remember") ?>
		</label>
	</div>
</div>