<?php
use components\Language;
use models\ImageModel;
?>

<div class="l-panel-form-container j-panel-settings-image-container">
    <label class="l-form-group">
        <span class="l-label"><?= Language::t("common", "name") ?></span>
        <input class="j-t__name j-validate l-form" type="text"/>
    </label>

    <label class="l-form-group">
        <span class="l-label-inline"><?= Language::t("image", "type") ?></span>
        <select class="j-t__type">
            <?php foreach(ImageModel::getTypeList() as $key => $value) { ?>
                <option value="<?= $key ?>"><?= $value ?></option>
            <?php } ?>
        </select>
    </label>

    <div class="l-form-group l-checkbox-container">
        <label class="l-label-container">
			<span class="l-body">
                <input class="j-t__use_albums l-checkbox" type="checkbox"/>
				<span class="l-icons">
					<i class="fa fa-square-o"></i>
					<i class="fa fa-check-square-o"></i>
				</span>
                <span class="l-label-text"><?= Language::t("image", "useAlbums") ?></span>
			</span>
        </label>
    </div>

    <input type="hidden" class="j-t__id" />
</div>