<?php

/**
 * PHP version 7
 *
 * @category TestS
 * @package  Applications
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications;

/**
 * Test application class
 *
 * @category TestS
 * @package  Applications
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */
class Test extends AbstractApplication
{

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        $this->setSite();
    }
}