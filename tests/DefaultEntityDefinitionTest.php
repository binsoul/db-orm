<?php

namespace BinSoul\Test\Db\Orm;

use BinSoul\Db\Definition\Column;
use BinSoul\Db\Orm\DefaultEntity;
use BinSoul\Db\Orm\DefaultEntityDefinition;
use BinSoul\Db\Orm\PropertyDefinition;

class DefaultEntityDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function test_uses_provided_data()
    {
        $property = $this->getMock(PropertyDefinition::class);

        $definition = new DefaultEntityDefinition(DefaultEntity::class, 'table', [$property], 'entity_id');
        $this->assertEquals(DefaultEntity::class, $definition->getEntityClass());
        $this->assertEquals('table', $definition->getTableName());
        $this->assertEquals('entity_id', $definition->getIdentityColumnName());
        $this->assertSame($property, $definition->getProperties()[0]);
    }

    public function test_can_change_table_name()
    {
        $definition = new DefaultEntityDefinition(DefaultEntity::class, 'table', []);
        $definition->setTableName('mytable');
        $this->assertEquals('mytable', $definition->getTableName());
    }

    public function test_can_change_identity_column_name()
    {
        $definition = new DefaultEntityDefinition(DefaultEntity::class, 'table', []);
        $definition->setIdentityColumnName('myid');
        $this->assertEquals('myid', $definition->getIdentityColumnName());
    }

    public function test_can_add_properties()
    {
        $property = $this->getMock(PropertyDefinition::class);

        $definition = new DefaultEntityDefinition(DefaultEntity::class, 'table', []);
        $definition->addProperty($property);
        $this->assertSame($property, $definition->getProperties()[0]);
    }

    public function test_finds_properties()
    {
        $column1 = $this->getMockBuilder(Column::class)->disableOriginalConstructor()->getMock();
        $column1->method('getName')->willReturn('id');
        $property1 = $this->getMock(PropertyDefinition::class);
        $property1->method('getColumn')->willReturn($column1);

        $column2 = $this->getMockBuilder(Column::class)->disableOriginalConstructor()->getMock();
        $column2->method('getName')->willReturn('column');
        $property2 = $this->getMock(PropertyDefinition::class);
        $property2->method('getColumn')->willReturn($column2);

        $definition = new DefaultEntityDefinition(DefaultEntity::class, 'table', [$property1, $property2], 'entity_id');
        $this->assertSame($property1, $definition->findProperty('id'));
        $this->assertSame($property2, $definition->findProperty('column'));
    }

    public function test_returns_null_for_missing_property()
    {
        $definition = new DefaultEntityDefinition(DefaultEntity::class, 'table', []);
        $this->assertNull($definition->findProperty('id'));
    }

    public function test_returns_initial_data()
    {
        $column1 = $this->getMockBuilder(Column::class)->disableOriginalConstructor()->getMock();
        $column1->method('getName')->willReturn('id');
        $property1 = $this->getMock(PropertyDefinition::class);
        $property1->method('getColumn')->willReturn($column1);

        $column2 = $this->getMockBuilder(Column::class)->disableOriginalConstructor()->getMock();
        $column2->method('getName')->willReturn('column');
        $column2->method('getInitialValue')->willReturn('data');
        $property2 = $this->getMock(PropertyDefinition::class);
        $property2->method('getColumn')->willReturn($column2);

        $definition = new DefaultEntityDefinition(DefaultEntity::class, 'table', [$property1, $property2], 'id');
        $this->assertEquals(['column' => 'data'], $definition->getInitialData());
    }
}
