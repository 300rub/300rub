/**
 * Abstract form
 */
ss.add(
    "adminBlockImageCrop",
    {
        parent: "commonComponentsWindowAbstract",

        parentOptions: {
            group: "image",
            controller: "crop",
            data: {
                blockId: options.blockId,
                id: options.id
            },
            success: $.proxy(this._onLoadDataSuccess, this),
            name: "image-crop",
            level: options.level,
            parent: options.parent
        },

        /**
         * Init
         */
        init: function() {
            this._container = null;

            ss.window.Abstract.call(
                this,

            );
        },


    }
);
