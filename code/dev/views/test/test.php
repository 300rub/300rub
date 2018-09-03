
<div class="grid-stack">
    <div class="grid-stack-item"
         data-gs-x="0" data-gs-y="0"
         data-gs-width="4" data-gs-height="2">
        <div class="grid-stack-item-content">111111</div>
    </div>
    <div class="grid-stack-item"
         data-gs-x="4" data-gs-y="0"
         data-gs-width="4" data-gs-height="4">
        <div class="grid-stack-item-content">222222222</div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.grid-stack').gridstack({
            acceptWidgets: '.grid-stack-item'
        });
    });
</script>