<?php
use components\Language;
?>
<div class="j-window-login-container">
	<div class="l-form-container">
		<label class="l-label-container">
			<span class="l-label"><?= Language::t("user", "login") ?></span>
			<span class="l-body">
				<input class="j-t__login j-validate l-form" type="text"/>
			</span>
		</label>
	</div>
	<div class="l-form-container">
		<label class="l-label-container">
			<span class="l-label"><?= Language::t("user", "password") ?></span>
			<span class="l-body">
				<input class="j-t__password j-validate l-form" type="password"/>
			</span>
		</label>
	</div>
	<div class="l-checkbox-container l-form-container">
		<label class="l-label-container">
			<span class="l-body">
				<input class="j-t__isRemember l-checkbox" type="checkbox"/>
				<span class="l-icons">
					<i class="fa fa-square-o"></i>
					<i class="fa fa-check-square-o"></i>
				</span>
				<?= Language::t("user", "remember") ?>
			</span>
		</label>
	</div>
</div>