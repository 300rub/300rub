!function ($, TestS) {
    'use strict';

    /**
     * Block editor
     *
     * @param {Object} options
     *
     * @type {TestS.Panel.Design.Block.Editor}
     */
    TestS.Panel.Design.Block.Editor = function (options) {
        this._designContainer = null;

        this._margin = null;

        TestS.Panel.Design.AbstractEditor.call(
            this,
            options
        );

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.Editor.prototype
        = Object.create(TestS.Panel.Design.AbstractEditor.prototype);

    /**
     * Constructor
     */
    TestS.Panel.Design.Block.Editor.prototype.constructor
        = TestS.Panel.Design.Block.Editor;

    TestS.Panel.Design.Block.Editor.prototype.init = function () {
        this
            ._setGroupEditors();
    };

    TestS.Panel.Design.Block.Editor.prototype._setGroupEditors = function () {
        this._margin = new TestS.Panel.Design.Block.Margin(
            {
                designContainer: this._designContainer,
                labels: this.getLabel(),
                values: this.getValues()
            }
        );
    };
}(window.jQuery, window.TestS);
