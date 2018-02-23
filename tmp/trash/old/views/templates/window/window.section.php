<?php
use testS\components\Language;
?>

<div class="j-window-section-container"></div>

<div class="j-window-section-line l-window-section-line d-hide">
    <div class="j-header l-section-line-header">
        <div class="j-title l-title">
            <a class="fa fa-chevron-up j-line-up l-line-up"></a>
            <a class="fa fa-chevron-down j-line-down l-line-down"></a>
            <label><?= Language::t("section", "line"); ?> <span class="j-line-number"></span>
                <select class="j-select-block l-select-block">
                    <option value="0" data-id="0" data-type="0">
                        <?php echo Language::t("section", "addBlock"); ?>
                    </option>
                </select>
            </label>
        </div>
        <a class="j-remove l-remove fa fa-close"></a>
    </div>
    <div class="j-grid-stack l-grid-stack grid-stack"></div>
</div>

<a class="j-window-section-add-line l-button">
    <?= Language::t("section", "addLine"); ?>
    <i class="fa fa-plus l-icon"></i>
</a>

<div class="j-window-section-grid-stack-item l-item grid-stack-item">
    <div class="j-content l-content grid-stack-item-content">
        <a class="j-remove l-remove fa fa-close"></a>
        <div class="j-label l-label"></div>
    </div>
</div>