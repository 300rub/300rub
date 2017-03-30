<style>
    #admin-buttons {
        position: fixed;
        right: 0;
        top: 50%;
        margin-top: -150px;
        z-index: 100;
    }

    #admin-buttons a {
        display: block;
        width: 50px;
        height: 60px;
        background: white;
        border: 1px solid #ececec;
        margin-top: -1px;
        position: relative;
        cursor: pointer;
    }
    #admin-buttons a:after {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: #272828;
        margin: 0;
        padding: 0;
        border: none;
        transform: scale(0);
        z-index: 1;
        transition: 0.15s linear;
    }
    #admin-buttons i {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        line-height: 60px;
        text-align: center;
        z-index: 2;
        color: #444;
        font-size: 18px;
    }
    #admin-buttons span {
        position: absolute;
        right: 50px;
        top: 50%;
        margin-top: -14px;
        line-height: 28px;
        margin-right: 30px;
        background: black;
        color: white;
        font-size: 13px;
        padding: 0 5px;
        opacity: 0;
        transition: 0.15s ease-in-out;
        border-radius: 3px;
        visibility: hidden;
    }

    #admin-buttons a:hover:after {
        transform: scale(1);
    }
    #admin-buttons a:hover i {
        color: white;
    }
    #admin-buttons a:hover span {
        opacity: 1;
        margin-right: 10px;
        visibility: visible;
    }
</style>

<?php
/**
 * @var bool $isDisplayBlocks
 * @var bool $isDisplaySections
 * @var bool $isDisplaySettings
 */
?>

<div id="admin-buttons">
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
    <a>
        <span>Logout</span>
        <i class="fa fa-sign-out"></i>
    </a>
</div>