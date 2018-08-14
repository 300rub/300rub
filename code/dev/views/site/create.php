<?php
/**
 * Variables
 *
 * @var string $createSite
 */
?>
<div class="container">
    <button class="btn btn-big btn-blue">
        <span><?php echo $createSite; ?></span>
    </button>
</div>

<div class="window window-create">
    <div class="header">
        <div class="title">Create title</div>
        <a class="close gray-red-link fas fa-times"></a>
    </div>

    <div class="body scroll-container">
        <div class="form-container form-container-text">
            <label>
                <span class="label-text">Name</span>
                <span class="form-instance-container">
                    <i class="fa fa-remove error"></i>
                    <input type="text" class="form-instance">
                </span>
                <span class="error"></span>
            </label>
        </div>

        <div class="form-container form-container-text">
            <label>
                <span class="label-text">Address</span>
                <span class="form-instance-container">
                    <i class="fa fa-remove error"></i>
                    <input type="text" class="form-instance">
                </span>
                <span class="error"></span>
            </label>
        </div>

        <div class="form-container form-container-text">
            <label>
                <span class="label-text">Email</span>
                <span class="form-instance-container">
                    <i class="fa fa-remove error"></i>
                    <input type="text" class="form-instance">
                </span>
                <span class="error"></span>
            </label>
        </div>

        <div class="form-container form-container-text">
            <label>
                <span class="label-text">Login</span>
                <span class="form-instance-container">
                    <i class="fa fa-remove error"></i>
                    <input type="text" class="form-instance">
                </span>
                <span class="error"></span>
            </label>
        </div>

        <div class="form-container form-container-text">
            <label>
                <span class="label-text">Password</span>
                <span class="form-instance-container">
                    <i class="fa fa-remove error"></i>
                    <input type="text" class="form-instance">
                </span>
                <span class="error"></span>
            </label>
        </div>
    </div>

    <div class="footer">
        <button class="btn btn-big btn-blue submit">
            <span>Create</span>
        </button>
    </div>
</div>

<div class="window-overlay"></div>
