<?php
use system\web\Language;
use models\TextModel;
?>

<div class="j-panel-settings-text-container">
    <div>
        <label for="panel-settings-text-t-name"><?= Language::t("common", "Name") ?></label>
        <input id="panel-settings-text-t-name" class="j-t__name j-validate" type="text"/>
    </div>
    <div>
        <label for="panel-settings-text-t-type"><?= Language::t("common", "Type") ?></label>
        <select id="panel-settings-text-t-type" class="j-t__type">
            <?php foreach (TextModel::getTypeList() as $value => $label) { ?>
                <option value="<?= $value ?>"><?= $label ?></option>
            <?php } ?>
        </select>
    </div>
    <div>
        <input id="panel-settings-text-t-is_editor" class="j-t__is_editor" type="checkbox"/>
        <label for="panel-settings-text-t-is_editor"><?= Language::t("common", "Is editor") ?></label>
    </div>
    <input type="hidden" class="j-t__id" />
</div>