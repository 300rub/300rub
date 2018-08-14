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

<script>
    $(document).ready(function() {
        new ss.window.site.Create();
    });
</script>