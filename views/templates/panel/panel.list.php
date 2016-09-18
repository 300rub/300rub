<?php
use components\Language;
?>

<div class="j-panel-list-item l-panel-list-item">
    <a class="j-label l-label">
        <i class="j-icon l-icon fa"></i>
        <span class="j-text"></span>
    </a>
    <a class="j-design l-design d-hide fa fa-paint-brush l-effect-bounce"><span></span></a>
    <a class="j-settings l-settings d-hide fa fa-cog l-effect-bounce"><span></span></a>
</div>

<a class="j-panel-list-add l-list-add">
    <i class="l-icon fa fa-plus"></i>
    <span class="j-label"><?= Language::t("common", "add") ?></span>
</a>

<div class="j-panel-list-display-block-container l-panel-list-display-block-container">
    <span class="l-text"><?= Language::t("block", "displayBlock") ?></span>
    <a class="j-link-all l-link d-hide">
        <i class="l-icon fa fa-globe"></i>
        <?= Language::t("block", "all") ?>
    </a>
    <span class="j-label-all l-label d-hide">
        <i class="l-icon fa fa-globe"></i>
        <?= Language::t("block", "all") ?>
    </span>
    <span class="l-separator">|</span>
    <a class="j-link-page l-link d-hide">
        <i class="l-icon fa fa-file-text-o"></i>
        <?= Language::t("block", "fromPage") ?>
    </a>
    <span class="j-label-page l-label d-hide">
        <i class="l-icon fa fa-globe"></i>
        <?= Language::t("block", "fromPage") ?>
    </span>
</div>