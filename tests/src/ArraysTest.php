<?php

/*
 * Queasy PHP Framework - Helper - Tests
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\helper\tests;

use queasy\helper\Arrays;

use PHPUnit\Framework\TestCase;

class ArraysTest extends TestCase
{
    /* Arrays::flatten() tests */

    public function testFlatten1Dimensional()
    {
        $input = [5, 'aa', 3, 4];

        $output = Arrays::flatten($input);

        $this->assertCount(4, $output);

        $this->assertArrayHasKey(0, $output);
        $this->assertEquals(5, $output[0]);

        $this->assertArrayHasKey(1, $output);
        $this->assertEquals('aa', $output[1]);

        $this->assertArrayHasKey(2, $output);
        $this->assertEquals(3, $output[2]);

        $this->assertArrayHasKey(3, $output);
        $this->assertEquals(4, $output[3]);

        $this->assertArrayNotHasKey(4, $output);
    }

    public function testFlatten1DimensionalWithKeys()
    {
        $input = [5, 'zzz' => 'aa', 3, 4];

        $output = Arrays::flatten($input);

        $this->assertCount(4, $output);

        $this->assertArrayHasKey(0, $output);
        $this->assertEquals(5, $output[0]);

        $this->assertArrayHasKey('zzz', $output);
        $this->assertEquals('aa', $output['zzz']);

        $this->assertArrayHasKey(1, $output);
        $this->assertEquals(3, $output[1]);

        $this->assertArrayHasKey(2, $output);
        $this->assertEquals(4, $output[2]);

        $this->assertArrayNotHasKey(3, $output);
    }
}

