<?php

/*
 * Queasy PHP Framework - Helper - Tests
 *
 * (c) Vitaly Demyanenko <vitaly_demyanenko@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

namespace queasy\helper\tests;

use InvalidArgumentException;

use queasy\helper\Arrays;

use PHPUnit\Framework\TestCase;

class ArraysTest extends TestCase
{
    /* flatten() tests */

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

    public function testFlatten2Dimensional()
    {
        $input = [5, 'aa', [7, 8, 9], 4];

        $output = Arrays::flatten($input);

        $this->assertCount(6, $output);

        $this->assertEquals(5, $output[0]);
        $this->assertEquals('aa', $output[1]);
        $this->assertEquals(7, $output[2]);
        $this->assertEquals(8, $output[3]);
        $this->assertEquals(9, $output[4]);
        $this->assertEquals(4, $output[5]);
    }

    public function testFlatten2DimensionalWithKeys()
    {
        $input = [5, 'aa' => 17, [7, 'bb' => 8, 9], 4];

        $output = Arrays::flatten($input);

        $this->assertCount(6, $output);

        $this->assertEquals(5, $output[0]);
        $this->assertArrayHasKey('aa', $output);
        $this->assertEquals(17, $output['aa']);
        $this->assertEquals(7, $output[1]);
        $this->assertArrayHasKey('bb', $output);
        $this->assertEquals(8, $output['bb']);
        $this->assertEquals(9, $output[2]);
        $this->assertEquals(4, $output[3]);
    }

    /* map() tests */

    public function testMap()
    {
        $source = [
            [
                'id' => 12,
                'name' => 'John'
            ], [
                'id' => 25,
                'name' => 'Mary'
            ]
        ];

        $result = Arrays::map('id', $source);

        $this->assertCount(2, $result);

        $this->assertArrayHasKey(12, $result);
        $this->assertEquals(12, $result[12]['id']);
        $this->assertEquals('John', $result[12]['name']);

        $this->assertArrayHasKey(25, $result);
        $this->assertEquals(25, $result[25]['id']);
        $this->assertEquals('Mary', $result[25]['name']);

        $result = Arrays::map('name', $source);

        $this->assertCount(2, $result);

        $this->assertArrayHasKey('John', $result);
        $this->assertEquals(12, $result['John']['id']);
        $this->assertEquals('John', $result['John']['name']);

        $this->assertArrayHasKey('Mary', $result);
        $this->assertEquals(25, $result['Mary']['id']);
        $this->assertEquals('Mary', $result['Mary']['name']);
    }

    public function testMapWithObjects()
    {
        $source = [
            (object) [
                'id' => 12,
                'name' => 'John'
            ], (object) [
                'id' => 25,
                'name' => 'Mary'
            ]
        ];

        $result = Arrays::map('id', $source);

        $this->assertCount(2, $result);

        $this->assertEquals(12, $result[12]->id);
        $this->assertEquals('John', $result[12]->name);

        $this->assertEquals(25, $result[25]->id);
        $this->assertEquals('Mary', $result[25]->name);

        $result = Arrays::map('name', $source);

        $this->assertCount(2, $result);

        $this->assertEquals(12, $result['John']->id);
        $this->assertEquals('John', $result['John']->name);

        $this->assertEquals(25, $result['Mary']->id);
        $this->assertEquals('Mary', $result['Mary']->name);
    }

    public function testInvalidMap()
    {
        $source = [
            [
                'id' => 12,
                'name' => 'John'
            ],
            12
        ];

        $this->expectException(InvalidArgumentException::class);

        Arrays::map('id', $source);
    }

    /* column() tests */

    public function testColumnIndexKey()
    {
        $source = [
            [
                'id' => 12,
                'name' => 'John'
            ], [
                'id' => 25,
                'name' => 'Mary'
            ]
        ];

        $result = Arrays::column($source, null, 'id');

        $this->assertCount(2, $result);

        $this->assertArrayHasKey(12, $result);
        $this->assertEquals(12, $result[12]['id']);
        $this->assertEquals('John', $result[12]['name']);

        $this->assertArrayHasKey(25, $result);
        $this->assertEquals(25, $result[25]['id']);
        $this->assertEquals('Mary', $result[25]['name']);
    }

    public function testColumnColumnKey()
    {
        $source = [
            [
                'id' => 12,
                'name' => 'John'
            ], [
                'id' => 25,
                'name' => 'Mary'
            ]
        ];

        $result = Arrays::column($source, 'name');

        $this->assertCount(2, $result);
        $this->assertEquals('John', $result[0]);
        $this->assertEquals('Mary', $result[1]);
    }

    public function testColumnIndexKeyAndColumnKey()
    {
        $source = [
            [
                'id' => 12,
                'name' => 'John'
            ], [
                'id' => 25,
                'name' => 'Mary'
            ]
        ];

        $result = Arrays::column($source, 'name', 'id');

        $this->assertCount(2, $result);

        $this->assertArrayHasKey(12, $result);
        $this->assertEquals('John', $result[12]);

        $this->assertArrayHasKey(25, $result);
        $this->assertEquals('Mary', $result[25]);
    }

    public function testColumnIndexKeyWithObjects()
    {
        $source = [
            (object) [
                'id' => 12,
                'name' => 'John'
            ], (object) [
                'id' => 25,
                'name' => 'Mary'
            ]
        ];

        $result = Arrays::column($source, null, 'id');

        $this->assertCount(2, $result);

        $this->assertEquals(12, $result[12]->id);
        $this->assertEquals('John', $result[12]->name);

        $this->assertEquals(25, $result[25]->id);
        $this->assertEquals('Mary', $result[25]->name);
    }

    public function testInvalidColumn()
    {
        $source = [
            [
                'id' => 12,
                'name' => 'John'
            ],
            12
        ];

        $this->expectException(InvalidArgumentException::class);

        Arrays::column($source, 'name', 'id');
    }

    /* merge() tests */

    public function mergeTest()
    {
        $arr1 = [
            'a' => [
                'ab' => 12,
                'ac' => 23
            ],
            'b' => 789,
            'c' => [
                12
            ]
        ];

        $arr2 = [
            'a' => [
                'ab' => 122
            ],
            'b' => [
                'ba' => 77
            ],
            'd' => 543
        ];

        $result = Arrays::merge($arr1, $arr2);

        $this->assertCount(4, $result);

        $this->assertArrayHasKey('a', $result);
        $this->assertArrayHasKey('b', $result);
        $this->assertArrayHasKey('c', $result);
        $this->assertArrayHasKey('d', $result);

        $this->assertIsArray($result['a']);
        $this->assertIsArray($result['b']);
        $this->assertIsArray($result['c']);

        $this->assertArrayHasKey('ab', $result['a']);
        $this->assertArrayHasKey('ac', $result['a']);
        $this->assertArrayHasKey('ba', $result['b']);
        $this->assertArrayHasKey(0, $result['c']);

        $this->assertEquals(122, $result['a']['ab']);
        $this->assertEquals(23, $result['a']['ac']);
        $this->assertEquals(77, $result['b']['ba']);
        $this->assertEquals(12, $result['c'][0]);
        $this->assertEquals(543, $result['d']);
    }
}

