<?php
use components\Language;
?>

<div class="j-panel-settings-section-container">
    <div>
        <label>
            <?= Language::t("common", "name") ?>
            <input class="j-seoModel__name j-validate l-form" type="text"/>
        </label>
    </div>
    <div>
        <label>
            URL
            <input class="j-seoModel__url j-validate l-form" type="text"/>
        </label>
    </div>
    <div>
        <label>
            <?= Language::t("section", "width") ?>
            <input class="j-t__width j-validate l-form" type="text"/>
        </label>
    </div>
    <div>
        <label>
            <input class="j-t__is_main" type="checkbox"/>
            <?= Language::t("section", "main") ?>
        </label>
    </div>
    <div>
        <label>
            <?= Language::t("common", "title") ?>
            <input class="j-seoModel__title j-validate l-form" type="text"/>
        </label>
    </div>
    <div>
        <label>
            <?= Language::t("section", "keywords") ?>
            <input class="j-seoModel__keywords j-validate l-form" type="text"/>
        </label>
    </div>
    <div>
        <label>
            <?= Language::t("section", "description") ?>
            <textarea class="j-seoModel__description j-validate l-form"></textarea>
        </label>
    </div>
    <input type="hidden" class="j-t__id" />
</div>