<?php
use components\Language;
?>

<div class="j-panel-settings-section-container">
    <div>
        <label for="panel-settings-section-seoname-name"><?= Language::t("common", "name") ?></label>
        <input id="panel-settings-section-seoname-name" class="j-seoModel__name j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-url">URL</label>
        <input id="panel-settings-section-seoname-url" class="j-seoModel__url j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-t-width"><?= Language::t("section", "width") ?></label>
        <input id="panel-settings-section-t-width" class="j-t__width j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-title"><?= Language::t("common", "title") ?></label>
        <input id="panel-settings-section-seoname-title" class="j-seoModel__title j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-keywords"><?= Language::t("section", "keywords") ?></label>
        <input id="panel-settings-section-seoname-keywords" class="j-seoModel__keywords j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-description"><?= Language::t("section", "description") ?></label>
        <textarea id="panel-settings-section-seoname-description" class="j-seoModel__description j-validate"></textarea>
    </div>
    <input type="hidden" class="j-t__id" />
</div>