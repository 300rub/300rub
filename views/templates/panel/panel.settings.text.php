<?php
use testS\components\Language;
use testS\models\TextModel;
?>

<div class="j-panel-settings-text-container">
    <div>
        <label for="panel-settings-text-t-name"><?= Language::t("common", "name") ?></label>
        <input id="panel-settings-text-t-name" class="j-t__name j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-text-t-type"><?= Language::t("common", "type") ?></label>
        <select id="panel-settings-text-t-type" class="j-t__type">
            <?php foreach (TextModel::getTypeList() as $value => $label) { ?>
                <option value="<?= $value ?>"><?= $label ?></option>
            <?php } ?>
        </select>
    </div>
    <div>
        <input id="panel-settings-text-t-isEditor" class="j-t__isEditor" type="checkbox"/>
        <label for="panel-settings-text-t-isEditor"><?= Language::t("text", "isEditor") ?></label>
    </div>
    <input type="hidden" class="j-t__id" />
</div>