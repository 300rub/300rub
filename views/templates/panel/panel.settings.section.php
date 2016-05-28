<?php
use components\Language;
?>

<div class="j-panel-settings-section-container">
    <div class="l-form-group">
        <label>
            <span class="l-label"><?= Language::t("common", "name") ?></span>
            <input class="j-seoModel__name j-validate l-form" type="text"/>
        </label>
    </div>
    <div class="l-form-group">
        <label>
            <span class="l-label">URL</span>
            <input class="j-seoModel__url j-validate l-form" type="text"/>
        </label>
    </div>
    <div class="l-form-group">
        <label>
            <span class="l-label-inline"><?= Language::t("section", "width") ?></span>
            <input class="j-t__width j-validate l-form-small" type="text"/>
            <span class="l-suffix j-width-suffix">px</span>
        </label>
    </div>
    <div class="l-form-group l-checkbox-container">
        <label class="l-label-container">
			<span class="l-body">
                <input class="j-t__is_main l-checkbox" type="checkbox"/>
				<span class="l-icons">
					<i class="fa fa-square-o"></i>
					<i class="fa fa-check-square-o"></i>
				</span>
                <span class="l-label-text"><?= Language::t("section", "main") ?></span>
			</span>
        </label>
    </div>

    <a class="l-form-seo-title">
        <?= Language::t("common", "seo") ?>
        <i class="fa fa-chevron-down"></i>
        <i class="fa fa-chevron-up"></i>
    </a>
    <div class="l-form-seo-container">
        <div class="l-form-group">
            <label>
                <span class="l-label"><?= Language::t("common", "title") ?></span>
                <input class="j-seoModel__title j-validate l-form" type="text"/>
            </label>
        </div>
        <div class="l-form-group">
            <label>
                <span class="l-label"><?= Language::t("section", "keywords") ?></span>
                <textarea class="j-seoModel__keywords j-validate l-form"></textarea>
            </label>
        </div>
        <div class="l-form-group">
            <label>
                <span class="l-label"><?= Language::t("section", "description") ?></span>
                <textarea class="j-seoModel__description j-validate l-form"></textarea>
            </label>
        </div>
    </div>
    <input type="hidden" class="j-t__id" />
</div>