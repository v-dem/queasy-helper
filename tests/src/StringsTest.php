<?php

/*
 * Queasy PHP Framework - Helper - Tests
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\helper\tests;

use queasy\helper\Strings;

use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    public function testStartsWith()
    {
        $result = Strings::startsWith('aaThis string starts with aa.', 'aa');

        $this->assertTrue($result);
    }

    public function testEndsWith()
    {
        $result = Strings::endsWith('This string ends with.', 'with.');

        $this->assertTrue($result);
    }
}

