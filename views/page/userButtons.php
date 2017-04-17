<?php
/**
 * @var bool   $isDisplayBlocks
 * @var bool   $isDisplaySections
 * @var bool   $isDisplaySettings
 * @var string $logoutYes
 * @var string $logoutNo
 * @var string $logoutConfirmText
 */
?>

<div id="user-buttons">
    <?php if ($isDisplayBlocks === true) { ?>
        <a>
            <span>Blocks</span>
            <i class="fa fa-th-large"></i>
        </a>
    <?php } ?>
    <?php if ($isDisplaySections === true) { ?>
        <a>
            <span>Sections</span>
            <i class="fa fa-file-o"></i>
        </a>
    <?php } ?>
    <?php if ($isDisplaySettings === true) { ?>
        <a>
            <span>Settings</span>
            <i class="fa fa-wrench"></i>
        </a>
    <?php } ?>
    <a>
        <span>Help</span>
        <i class="fa fa-question"></i>
    </a>
    <a id="user-button-logout">
        <span>Logout</span>
        <i class="fa fa-sign-out"></i>
    </a>
    <div
        class="logout-confirmation hidden"
        data-yes="<?= $logoutYes ?>"
        data-no="<?= $logoutNo ?>"
    >
        <div><?= $logoutConfirmText ?></div>
    </div>
</div>