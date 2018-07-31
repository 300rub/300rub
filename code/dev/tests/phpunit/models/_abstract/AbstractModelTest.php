<?php

namespace ss\tests\phpunit\models\_abstract;

use ss\models\_abstract\AbstractModel;
use ss\tests\phpunit\_abstract\AbstractUnitTest;

/**
 * Abstract class to work with model tests
 */
abstract class AbstractModelTest extends AbstractUnitTest
{

    /**
     * Gets model by name
     *
     * @param string $name Model name
     *
     * @return AbstractModel
     */
    protected function getModelByName($name)
    {
        return new $name;
    }

    /**
     * Gets string with tags
     *
     * @param string $value Value
     *
     * @return string
     */
    protected function getStringWithTags($value)
    {
        $value = '' .
            '<!--...--><!DOCTYPE><a><abbr><address><area><article>
            <aside><audio><b><base><bdi><bdo><blockquote>
            <body><br><button><canvas><caption><cite><code><col>
            <colgroup><datalist><dd><del><details><dfn>
            <dialog><div><dl><dt><em><embed><fieldset><figcaption>
            <figure><footer><form><h1><head><header><hr>
            <html><i><iframe><img><input><ins><kbd><keygen><label>
            <legend><li><link><main><map><mark><menu>
            <menuitem><meta><meter><nav><noscript><object><ol>
            <optgroup><option><output><p><param><picture><pre>
            <progress><q><rp><rt><ruby><s><samp><script><section>
            <select><small><source><span><strong><style>
            <summary><table><tbody><td><textarea><tfoot><th>
            <thead><time><title><tr><track><u><ul><var>
            <video><wbr></a></abbr></address></area></article>
            </aside></audio></b></base></bdi></bdo></blockquote>
            </body></br></button></canvas></caption></cite></code>
            </col></colgroup></datalist></dd></del></details>
            </dialog></div></dl></dt></em></embed></fieldset>
            </figcaption></figure></footer></form></h1></head>
            </hr></html></i></iframe></img></input></ins></kbd>
            </keygen></label></legend></li></link></main></map>
            </mark></menu></menuitem></meta></meter></nav></noscript>
            </object></ol></optgroup></option></output></p>
            </param></picture></pre></progress></q></rp></rt>
            </ruby></s></samp></script></section></select></small>
            </source><span><strong><style></summary></table></tbody>
            </td></textarea></tfoot></th></thead></time>
            </title></tr></track></u></ul></var></video></wbr></dfn>
            </header><script>alert("cracked");</script>' .
            $value .
            '<?php echo "123"; eixt(); ?><% ?> <?= <?php';

        return $value;
    }
}
