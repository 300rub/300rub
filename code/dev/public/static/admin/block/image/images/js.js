ss.add(
    "adminBlockImageImages",
    {
        /**
         * Default options
         *
         * @type {Object}
         */
        defaultOptions: {
            appendTo: null,
            isSortable: false,
            list: [
                {
                    id: 0,
                    url: "",
                    name: ""
                }
            ],
            create: {
                hasOperation: false,
                isSingleton: false,
                group: "",
                controller: "",
                data: {}
            },
            update: {
                hasOperation: false,
                blockId: 0,
                level: 2,
                parent: ""
            },
            delete: {
                hasOperation: false,
                group: "",
                controller: "",
                data: {},
                confirm: {
                    text: "",
                    yes: "",
                    no: ""
                }
            }
        },

        /**
         * Container
         *
         * @var {Object}
         */
        container: null,

        /**
         * Upload container
         *
         * @var {Object}
         */
        uploadContainer: null,

        /**
         * Upload form
         *
         * @var {Object}
         */
        uploadForm: null,

        /**
         * Upload progress
         *
         * @var {Object}
         */
        uploadProgress: null,

        /**
         * Upload count current
         *
         * @var {Object}
         */
        uploadCountCurrent: null,

        /**
         * Upload count all
         *
         * @var {Object}
         */
        uploadCountAll: null,

        /**
         * Files
         *
         * @var {Array}
         */
        files: [],

        /**
         * Init
         */
        init: function () {
            this.container = null;
            this.uploadContainer = null;
            this.uploadForm = null;
            this.uploadProgress = null;
            this.uploadCountCurrent = null;
            this.uploadCountAll = null;
            this.files = [];

            this.extendDefaultOptions(this.defaultOptions);
        }
    }
);
