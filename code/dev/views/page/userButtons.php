<?php
/**
 * Variables
 *
 * @var bool   $isDisplayBlocks
 * @var bool   $isDisplaySections
 * @var bool   $isDisplaySettings
 * @var string $logoutYes
 * @var string $logoutNo
 * @var string $logoutConfirmText
 *
 * phpcs:disable Generic.Files.InlineHTML
 */
?>

<div id="user-buttons">
    <?php if ($isDisplayBlocks === true) { ?>
        <a id="user-button-block">
            <span>Blocks</span>
            <i class="fas fa-th-large"></i>
        </a>
    <?php } ?>
    <?php if ($isDisplaySections === true) { ?>
        <a>
            <span>Sections</span>
            <i class="far fa-file"></i>
        </a>
    <?php } ?>
    <a id="user-button-settings">
        <span>Settings</span>
        <i class="fas fa-wrench"></i>
    </a>
    <a>
        <span>Help</span>
        <i class="fas fa-question"></i>
    </a>
    <a id="user-button-logout">
        <span>Logout</span>
        <i class="fas fa-sign-out-alt"></i>
    </a>
    <div
        class="logout-confirmation hidden"
        data-yes="<?php echo $logoutYes; ?>"
        data-no="<?php echo $logoutNo; ?>"
    >
        <div><?php echo $logoutConfirmText; ?></div>
    </div>
</div>
