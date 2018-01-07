<?php
use testS\components\Language;
use testS\models\ImageModel;

?>

<div class="l-panel-form-container j-panel-settings-image-container">
    <label class="l-form-group">
        <span class="l-label"><?= Language::t("common", "name") ?></span>
        <input class="j-t__name j-validate l-form" type="text"/>
    </label>

    <div class="l-form-group l-switch-container">
        <label class="l-label-container">
            <input class="j-t__useAlbums l-checkbox" type="checkbox"/>
            <span class="l-content">
                <span class="l-icons">
                    <i class="fa fa-square-o l-not-checked"></i>
                    <i class="fa fa-check-square-o l-checked"></i>
                </span>
                <span class="l-label-text"><?= Language::t("image", "useAlbums") ?></span>
            </span>
        </label>
    </div>

    <div class="l-form-group l-switch-container">
        <label class="l-label-container">
            <input class="j-t__type l-switch" type="radio" value="<?= ImageModel::TYPE_ZOOM ?>" />
            <span class="l-content">
                <span class="l-icons">
                    <i class="fa fa-circle-o l-not-checked"></i>
                    <i class="fa fa-check-circle-o l-checked"></i>
                </span>
                <span class="l-label-text"><?= Language::t("image", "zoom") ?></span>
                <span class="l-data">

                    <span class="l-switch-container">
                        <label class="l-label-container">
                            <input class="j-t__useCrop l-switch" type="checkbox"/>
                            <span class="l-content">
                                <span class="l-icons">
                                    <i class="fa fa-square-o l-not-checked"></i>
					                <i class="fa fa-check-square-o l-checked"></i>
                                </span>
                                <span class="l-label-text"><?= Language::t("image", "useCrop") ?></span>
                                <span class="l-data">

                                    <span class="l-title"><?= Language::t("image", "bigImages") ?></span>

                                    <span class="l-switch-container">
                                        <label class="l-label-container">
                                             <input class="j-exact-size l-switch" type="checkbox"/>
                                             <span class="l-content">
                                                <span class="l-icons">
                                                    <i class="fa fa-square-o l-not-checked"></i>
                                                    <i class="fa fa-check-square-o l-checked"></i>
                                                </span>
                                                <span class="l-label-text"><?= Language::t("image", "exactSize") ?></span>
                                                <span class="l-data">

                                                    <span class="l-form-group">
                                                        <input class="j-t__cropWidth l-form-small" type="text"/>
                                                        <span class="l-suffix j-width-suffix">px</span>
                                                        <span class="l-separator">X</span>
                                                        <input class="j-t__cropHeight l-form-small" type="text"/>
                                                        <span class="l-suffix j-width-suffix">px</span>
                                                    </span>

                                                </span>
                                             </span>
                                        </label>
                                    </span>

                                     <span class="l-switch-container">
                                         <label class="l-label-container">
                                             <input class="j-proportions l-switch" type="checkbox"/>
                                             <span class="l-content">
                                                <span class="l-icons">
                                                    <i class="fa fa-square-o l-not-checked"></i>
                                                    <i class="fa fa-check-square-o l-checked"></i>
                                                </span>
                                                <span class="l-label-text"><?= Language::t("image", "proportions") ?></span>
                                                <span class="l-data">

                                                    <span class="l-form-group">
                                                        <input class="j-t__cropX l-form-small" type="text"/>
                                                        <span class="l-separator">X</span>
                                                        <input class="j-t__cropY l-form-small" type="text"/>
                                                    </span>

                                                </span>
                                             </span>
                                          </label>
                                     </span>

                                    <span class="l-title"><?= Language::t("image", "thumbs") ?></span>

                                    <span class="l-form-group">
                                        <input class="j-t__thumbCropWidth l-form-small" type="text"/>
                                        <span class="l-suffix j-width-suffix">px</span>
                                        <span class="l-separator">X</span>
                                        <input class="j-t__thumbCropHeight l-form-small" type="text"/>
                                        <span class="l-suffix j-width-suffix">px</span>
                                    </span>

                                    <label class="l-label-container">
                                        <input class="j-t__useAlbums l-checkbox" type="checkbox"/>
                                        <span class="l-content">
                                            <span class="l-icons">
                                                <i class="fa fa-square-o l-not-checked"></i>
                                                <i class="fa fa-check-square-o l-checked"></i>
                                            </span>
                                            <span class="l-label-text"><?= Language::t("image", "useAlbums") ?></span>
                                        </span>
                                    </label>

                                </span>
                            </span>
                        </label>
                    </span>

                </span>
            </span>
        </label>
    </div>


    <input type="hidden" class="j-t__id"/>
</div>