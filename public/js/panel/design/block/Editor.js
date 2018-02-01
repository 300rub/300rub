!function ($, TestS) {
    'use strict';

    /**
     * Block editor
     *
     * @property {TestS.Panel.Design.Block.Editor} _object
     *
     * @type {TestS.Panel.Design.Block.Editor}
     */
    TestS.Panel.Design.Block.Editor = function () {
        TestS.Panel.Design.AbstractEditor.call(
            this,
            {

            }
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

    };
}(window.jQuery, window.TestS);
