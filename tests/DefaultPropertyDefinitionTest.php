<?php

namespace BinSoul\Test\Db\Orm;

use BinSoul\Db\Definition\Column;
use BinSoul\Db\Orm\DefaultPropertyDefinition;

class DefaultPropertyDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function test_uses_provided_data()
    {
        $column = $this->getMockBuilder(Column::class)->disableOriginalConstructor()->getMock();

        $property = new DefaultPropertyDefinition($column);
        $this->assertSame($column, $property->getColumn());
    }
}
