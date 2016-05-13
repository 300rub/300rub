<?php
use components\Language;
?>
<div class="l-window j-window">
	<div class="l-window-container">
		<form class="j-window-form" method="post">
			<a href="#" class="l-close j-close fa fa-times"></a>
	
			<div class="l-header j-header j-hide"></div>
			<div class="l-container j-container">
				<div class="j-loader j-hide">
					Loading
				</div>
			</div>
			<div class="l-footer j-footer j-hide">
				<a class="j-submit l-submit hvr-ripple-out" href="#">
					<span class="j-label"><?= Language::t("common", "save") ?></span>
					<div class="j-loader j-hide">
						Loading
					</div>
				</a>
			</div>
		</form>
	</div>
	<div class="l-cloud">
		<div class="l-cloud-top"></div>
		<div class="l-cloud-sides"></div>
		<div class="l-cloud-bottom"></div>
	</div>
</div>

<div class="l-overlay j-overlay"></div>