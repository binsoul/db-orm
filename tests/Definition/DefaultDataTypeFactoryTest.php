<?php

namespace BinSoul\Test\Db\Orm\Definition;

use BinSoul\Db\Definition\DataType;
use BinSoul\Db\Definition\DataType\CharType;
use BinSoul\Db\Orm\Definition\DefaultDataTypeFactory;

class DefaultDataTypeFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function instances()
    {
        return [
            ['identity', []],
            ['entity', []],
            ['integer', []],
            ['string', ['length' => 1]],
            ['char', ['length' => 1]],
            ['decimal', ['precision' => 14, 'scale' => 8]],
            ['boolean', []],
            ['datetime', []],
            ['date', []],
            ['time', []],
        ];
    }

    /**
     * @dataProvider instances
     */
    public function test_creates_instances($type, $options)
    {
        $factory = new DefaultDataTypeFactory();
        $this->assertInstanceOf(DataType::class, $factory->build($type, $options));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_throws_exception_for_unknown_type()
    {
        $factory = new DefaultDataTypeFactory();
        $factory->build('foobar', []);
    }

    public function test_uses_identity_type()
    {
        $factory = new DefaultDataTypeFactory(new CharType(32));
        $this->assertInstanceOf(CharType::class, $factory->build('identity', []));
    }
}
