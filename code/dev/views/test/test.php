<style>
    body {
        background: #ccc;;
    }

    body.drag-over {
        background: white;
    }

    .container {
        width: 500px;
        height: 200px;
        background-color: white;
        border: 1px solid #ccc;
        margin: 15px;
        position: relative;
    }

    /*.container .drag-overlay {*/
        /*background: #ccc;*/
        /*//display: none;*/
        /*position: absolute;*/
        /*z-index: 100;*/
        /*left: 20px;*/
        /*top: 20px;*/
        /*right: 20px;*/
        /*bottom: 20px;*/
    /*}*/

    .container.drag-over {
        background: #ccc;
    }
</style>


<div class="container">
<!--    <div class="drag-overlay">-->
<!--        <div class="text">Drop files here</div>-->
<!--    </div>-->
</div>

<script>
    var body = $("body");
    var container = $(document);

    container
        .on("dragover", function() {
            body.addClass("drag-over");
            return false;
        })
        .on("dragleave", function() {
            body.removeClass("drag-over");
            return false;
        })
        .on("drop", function(event) {
            body.removeClass("drag-over");

            var files = event["originalEvent"]["target"]["files"]
                || event["originalEvent"]["dataTransfer"]["files"];

            console.log(files);

            return false;
        });

</script>