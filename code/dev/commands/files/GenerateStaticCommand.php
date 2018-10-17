<?php

namespace ss\commands\files;

use ss\application\components\file\_abstract\AbstractFile;
use ss\application\components\file\Html;
use ss\application\components\file\Js;
use ss\application\components\file\Less;
use ss\application\exceptions\FileException;
use MatthiasMullie\Minify\CSS as CssMinimizer;
use MatthiasMullie\Minify\JS as JsMinimizer;
use ss\commands\_abstract\AbstractCommand;
use voku\helper\HtmlMin as HtmlMinimizer;

/**
 * Class for working with compress static
 */
class GenerateStaticCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @throws FileException
     *
     * @return void
     */
    public function run()
    {
        $types = [
            AbstractFile::TYPE_COMMON,
            AbstractFile::TYPE_ADMIN,
            AbstractFile::TYPE_SITE,
        ];

        foreach ($types as $type) {
            $this
                ->_generateHtml($type)
                ->_generateCss($type)
                ->_generateJs($type);
        }
    }

    /**
     * Generates HTML
     *
     * @param string $type Type
     *
     * @return GenerateStaticCommand
     */
    private function _generateHtml($type)
    {
        $htmlObject = new Html($type);
        $htmlObject->setHasMinimized(false);
        $html = $htmlObject->getHtml();

        $minimizer = new HtmlMinimizer();
        $html = $minimizer->minify($html);

        $path = $htmlObject->getMinimizedPath();

        $handle = fopen($path, 'w');
        fwrite($handle, $html);

        return $this;
    }

    /**
     * Generates CSS
     *
     * @param string $type Type
     *
     * @return GenerateStaticCommand
     */
    private function _generateCss($type)
    {
        $lessObject = new Less($type);
        $lessObject->setHasMinimized(false);
        $css = $lessObject->getCss();

        $minimizer = new CssMinimizer();
        $minimizer->add($css);

        $path = $lessObject->getMinimizedPath();

        $minimizer->minify($path);

        return $this;
    }

    /**
     * Generates JS
     *
     * @param string $type Type
     *
     * @return GenerateStaticCommand
     */
    private function _generateJs($type)
    {
        $jsObject = new Js($type);
        $jsObject->setHasMinimized(false);
        $jsList = $jsObject->getFullPathFileList();

        $minimizer = new JsMinimizer();
        foreach ($jsList as $file) {
            $minimizer->add($file);
        }

        $path = $jsObject->getMinimizedPath();

        $minimizer->minify($path);

        return $this;
    }

//    /**
//     * Generates JS files
//     *
//     * @param array $staticMap JS static map
//     *
//     * @return GenerateStaticCommand
//     */
//    private function _generateJs($staticMap)
//    {
//        $minimizer = new JS();
//        $hasJs = false;
//
//        if (array_key_exists('js', $staticMap['libs']) === true) {
//            foreach ($staticMap['libs']['js'] as $jsName) {
//                $minimizer->add(
//                    $this->_publicDir . '/js/' . $jsName . '.js'
//                );
//            }
//
//            $hasJs = true;
//        }
//
//        if (array_key_exists('js', $staticMap) === true) {
//            foreach ($staticMap['js'] as $jsName) {
//                $minimizer->add(
//                    $this->_publicDir . '/js/' . $jsName . '.js'
//                );
//            }
//
//            $hasJs = true;
//        }
//
//        if ($hasJs === true) {
//            $minimizer->minify(
//                $this->_publicDir . '/js/' . $staticMap['compiledJs'] . '.js'
//            );
//        }
//
//        return $this;
//    }
//
//    /**
//     * Generates CSS files
//     *
//     * @param array $staticMap CSS static map
//     *
//     * @return GenerateStaticCommand
//     */
//    private function _generateCss($staticMap)
//    {
//        $minimizer = new CSS();
//        $hasCss = false;
//
//        if (array_key_exists('css', $staticMap['libs']) === true) {
//            foreach ($staticMap['libs']['css'] as $cssName) {
//                $minimizer->add(
//                    $this->_publicDir . '/css/' . $cssName . '.css'
//                );
//            }
//
//            $hasCss = true;
//        }
//
//        if (array_key_exists('less', $staticMap) === true
//            && $staticMap['less'] !== ''
//        ) {
//            $less = new \lessc;
//            $minimizer->add(
//                $less->compileFile(
//                    $this->_publicDir . '/less/' . $staticMap['less'] . '.less'
//                )
//            );
//
//            $hasCss = true;
//        }
//
//        if ($hasCss === true) {
//            $minimizer->minify(
//                $this->_publicDir . '/css/' . $staticMap['compiledCss'] . '.css'
//            );
//        }
//
//        return $this;
//    }
}
