<?php

namespace ss\commands\files;

use ss\application\App;
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
     * Static map
     *
     * @var array
     */
    private $_staticMap = [];

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
        $this->_staticMap = CODE_ROOT . '/config/other/static.php';
        $this->_publicDir = CODE_ROOT . '/public';

        $this
            ->_generateJs()
            ->_generateCss();
    }

    /**
     * Generates JS files
     *
     * @return GenerateStaticCommand
     */
    private function _generateJs()
    {
        foreach ($this->_staticMap as $staticMap) {
            $minimizer = new JS();

            foreach ($staticMap['libs']['js'] as $jsName) {
                $minimizer->add(
                    $this->_publicDir . '/js/' . $jsName . '.js'
                );
            }

            foreach ($staticMap['js'] as $jsName) {
                $minimizer->add(
                    $this->_publicDir . '/js/' . $jsName . '.js'
                );
            }

            $minimizer->minify(
                $this->_publicDir . '/js/' . $staticMap['compiledJs'] . '.js'
            );
        }

        return $this;
    }

    /**
     * Generates CSS files
     *
     * @return GenerateStaticCommand
     */
    private function _generateCss()
    {
        foreach ($this->_staticMap as $staticMap) {
            $minimizer = new CSS();

            foreach ($staticMap['libs']['css'] as $cssName) {
                $minimizer->add(
                    $this->_publicDir . '/css/' . $cssName . '.css'
                );
            }

            $less = new \lessc;
            $minimizer->add(
                $less->compileFile(
                    $this->_publicDir . '/less/' . $staticMap['less'] . '.less'
                )
            );

            $minimizer->minify(
                $this->_publicDir . '/css/' . $staticMap['compiledCss'] . '.css'
            );
        }

        return $this;
    }
}
