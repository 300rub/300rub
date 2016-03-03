<?php
use system\web\Language;
?>

<div class="j-panel-settings-section-container">
    <div>
        <label for="panel-settings-section-seoname-name"><?= Language::t("common", "Name") ?></label>
        <input id="panel-settings-section-seoname-name" class="j-seoModel__name j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-url"><?= Language::t("common", "URL") ?></label>
        <input id="panel-settings-section-seoname-url" class="j-seoModel__url j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-t-width"><?= Language::t("common", "Width") ?></label>
        <input id="panel-settings-section-t-width" class="j-t__width j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-title"><?= Language::t("common", "Title") ?></label>
        <input id="panel-settings-section-seoname-title" class="j-seoModel__title j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-keywords"><?= Language::t("common", "Keywords") ?></label>
        <input id="panel-settings-section-seoname-keywords" class="j-seoModel__keywords j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-section-seoname-description"><?= Language::t("common", "Description") ?></label>
        <textarea id="panel-settings-section-seoname-description" class="j-seoModel__description j-validate"></textarea>
    </div>
</div>