/**
 * Abstract form
 */
ss.add(
    "commonContentBlockUpdate",
    {
        /**
         * Filtered list
         *
         * @var {Array}
         */
        filteredIdList: [],

        /**
         * Init
         */
        init: function() {
            this
                .setFilteredIdList()
                .loadContent();
        },

        /**
         * Sets filtered ID list
         */
        setFilteredIdList: function () {
            this.filteredIdList = [];

            $.each(this._idList, $.proxy(function(i, blockId) {
                if ($(".block-" + blockId).length > 0) {
                    this.filteredIdList.push(blockId);
                }
            }, this));

            return this;
        },

        /**
         * Loads blocks content
         */
        loadContent: function () {
            var uri = window.location.pathname + window.location.search;

            ss.init(
                "ajax",
                {
                    data: {
                        group: "block",
                        controller: "content",
                        data: {
                            idList: this.filteredIdList,
                            uri: uri
                        }
                    },
                    error: $.proxy(this._onError, this),
                    success: $.proxy(this._onSuccess, this)
                }
            );

            return this;
        },

        /**
         * On error
         */
        onError: function () {
        },

        /**
         * On success
         *
         * @param {Object} data
         */
        onSuccess: function (data) {
            $.each(data.content, $.proxy(function(blockId, blockData) {
                var blockElement = $(".block-" + blockId);

                if (blockElement.length === 0) {
                    return false;
                }

                var gridElement = blockElement.parent();
                blockElement.remove();
                gridElement.append(blockData.html);

                $.each(blockData.css, $.proxy(function(cssId, cssValue) {
                    var cssElement = $("#" + cssId);
                    if (cssElement.length === 0) {
                        return false;
                    }

                    cssValue = "<style>" + cssValue + "</style>";

                    cssElement.html(cssValue);
                }, this));

                $.each(blockData.js, $.proxy(function(i, jsValue) {
                    var fullJs = "<script>!function(){" + jsValue + "}();</script>";
                    ss.init("app").append(fullJs);
                }, this));
            }, this));
        }
    }
);
