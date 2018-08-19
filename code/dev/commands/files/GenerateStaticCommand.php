<?php

namespace ss\commands\files;

use ss\application\exceptions\FileException;
use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;
use ss\commands\_abstract\AbstractCommand;

/**
 * Class for working with compress static
 */
class GenerateStaticCommand extends AbstractCommand
{

    /**
     * Public dir
     *
     * @var string
     */
    private $_publicDir = '';

    /**
     * Runs the command
     *
     * @throws FileException
     *
     * @return void
     */
    public function run()
    {
        $staticMaps = [];
        $staticMaps[] = include CODE_ROOT .
            '/config/other/static.php';
        $staticMaps[] = include CODE_ROOT .
            '/config/other/staticSite.php';
        $staticMaps[] = include CODE_ROOT .
            '/config/other/staticError.php';

        $this->_publicDir = CODE_ROOT . '/public';

        foreach ($staticMaps as $map) {
            foreach ($map as $staticMap) {
                $this
                    ->_generateJs($staticMap)
                    ->_generateCss($staticMap);
            }
        }
    }

    /**
     * Generates JS files
     *
     * @param array $staticMap JS static map
     *
     * @return GenerateStaticCommand
     */
    private function _generateJs($staticMap)
    {
        $minimizer = new JS();
        $hasJs = false;

        if (array_key_exists('js', $staticMap['libs']) === true) {
            foreach ($staticMap['libs']['js'] as $jsName) {
                $minimizer->add(
                    $this->_publicDir . '/js/' . $jsName . '.js'
                );
            }

            $hasJs = true;
        }

        if (array_key_exists('js', $staticMap) === true) {
            foreach ($staticMap['js'] as $jsName) {
                $minimizer->add(
                    $this->_publicDir . '/js/' . $jsName . '.js'
                );
            }

            $hasJs = true;
        }

        if ($hasJs === true) {
            $minimizer->minify(
                $this->_publicDir . '/js/' . $staticMap['compiledJs'] . '.js'
            );
        }

        return $this;
    }

    /**
     * Generates CSS files
     *
     * @param array $staticMap CSS static map
     *
     * @return GenerateStaticCommand
     */
    private function _generateCss($staticMap)
    {
        $minimizer = new CSS();
        $hasCss = false;

        if (array_key_exists('css', $staticMap['libs']) === true) {
            foreach ($staticMap['libs']['css'] as $cssName) {
                $minimizer->add(
                    $this->_publicDir . '/css/' . $cssName . '.css'
                );
            }

            $hasCss = true;
        }

        if (array_key_exists('less', $staticMap) === true
            && $staticMap['less'] !== ''
        ) {
            $less = new \lessc;
            $minimizer->add(
                $less->compileFile(
                    $this->_publicDir . '/less/' . $staticMap['less'] . '.less'
                )
            );

            $hasCss = true;
        }

        if ($hasCss === true) {
            $minimizer->minify(
                $this->_publicDir . '/css/' . $staticMap['compiledCss'] . '.css'
            );
        }

        return $this;
    }
}
