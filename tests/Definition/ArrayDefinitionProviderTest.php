<?php

namespace BinSoul\Test\Db\Orm\Definition;

use BinSoul\Db\Orm\Definition\ArrayDefinitionProvider;
use BinSoul\Db\Orm\EntityDefinition;

class ArrayDefinitionProviderTest extends \PHPUnit_Framework_TestCase
{
    private $definitions = [
        'fooClass' => [
            'table' => 'foo',
            'properties' => [
                [
                    'column' => 'id',
                    'type' => 'identity',
                ],
                [
                    'column' => 'column',
                    'type' => 'string',
                    'length' => '32',
                    'default' => '1234567890',
                ],
            ],
        ],
    ];

    public function test_builds_definition()
    {
        $provider = new ArrayDefinitionProvider($this->definitions);
        $this->assertInstanceOf(EntityDefinition::class, $provider->define('fooClass'));
        $this->assertNull($provider->define('barClass'));
    }
}
