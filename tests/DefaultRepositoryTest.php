<?php

namespace BinSoul\Test\Db\Orm;

use BinSoul\Db\Database;
use BinSoul\Db\Orm\DefaultEntity;
use BinSoul\Db\Orm\DefaultEntityFactory;
use BinSoul\Db\Orm\DefaultRepository;
use BinSoul\Db\Orm\EntityDefinition;
use BinSoul\Db\Result;

class DefaultRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Database
     */
    private function buildDatabase()
    {
        $rowResult = $this->getMock(Result::class);
        $rowResult->method('row')->willReturnOnConsecutiveCalls(['id' => 1, 'column' => 'value1'], ['id' => 2, 'column' => 'value2']);
        $rowResult->method('all')->willReturn([['id' => 1, 'column' => 'value1'], ['id' => 2, 'column' => 'value2']]);
        $rowResult->method('autoIncrementID')->willReturnOnConsecutiveCalls(1234, 5678);

        $database = $this->getMock(Database::class);
        $database->method('execute')->willReturn($rowResult);
        $database->method('insert')->willReturn($rowResult);
        $database->method('update')->willReturn($rowResult);

        return $database;
    }

    /**
     * @return EntityDefinition
     */
    private function buildDefinition()
    {
        $result = $this->getMock(EntityDefinition::class);
        $result->method('getEntityClass')->willReturn(DefaultEntity::class);
        $result->method('getTableName')->willReturn('table');
        $result->method('getIdentityColumnName')->willReturn('id');
        $result->method('getInitialData')->willReturn(['column' => 'data']);

        return $result;
    }

    public function test_builds_new_entity_with_initial_data()
    {
        $database = $this->buildDatabase();
        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);
        $entity = $repository->newEntity();
        $this->assertInstanceOf(DefaultEntity::class, $entity);
        $this->assertNull($entity->getId());
        $this->assertEquals('data', $entity->column);
    }

    public function test_returns_new_entity_if_id_equals_zero()
    {
        $database = $this->buildDatabase();
        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entity = $repository->loadEntity(0);
        $this->assertNull($entity->getId());
        $this->assertEquals('data', $entity->column);
    }

    public function test_loads_entity()
    {
        $database = $this->buildDatabase();
        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entity = $repository->loadEntity(1);
        $this->assertEquals(1, $entity->getId());
        $this->assertEquals('value1', $entity->column);
    }

    public function test_loads_entity_list()
    {
        $database = $this->buildDatabase();
        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entities = $repository->loadList([]);
        $this->assertCount(0, $entities);

        $entities = $repository->loadList([1, 2]);

        $this->assertCount(2, $entities);
        $this->assertEquals('value1', $entities[0]->column);
        $this->assertEquals('value2', $entities[1]->column);
    }

    public function test_loads_all_entities()
    {
        $database = $this->buildDatabase();
        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entities = $repository->loadAll();

        $this->assertCount(2, $entities);
        $this->assertEquals('value1', $entities[0]->column);
        $this->assertEquals('value2', $entities[1]->column);
    }

    public function test_inserts_entities()
    {
        $database = $this->buildDatabase();
        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entity = $repository->newEntity();
        $entity = $repository->saveEntity($entity);

        $this->assertEquals(1234, $entity->getId());
    }

    public function test_updates_entities()
    {
        $database = $this->buildDatabase();
        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entity = $repository->loadEntity(1);
        $entity = $repository->saveEntity($entity);

        $this->assertEquals(1, $entity->getId());
    }

    public function test_saves_entity_lists()
    {
        $database = $this->buildDatabase();
        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entities = [
            $repository->newEntity(),
            $repository->newEntity(),
        ];

        $entities = $repository->saveList($entities);

        $this->assertEquals(1234, $entities[0]->getId());
        $this->assertEquals(5678, $entities[1]->getId());
    }

    public function test_deletes_entities()
    {
        $database = $this->buildDatabase();
        $database->expects($this->any())->method('delete');

        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entity = $repository->newEntity();
        $entity = $repository->deleteEntity($entity);

        $this->assertFalse($entity->exists());

        $entity = $repository->loadEntity(1);
        $entity = $repository->deleteEntity($entity);

        $this->assertFalse($entity->exists());
    }

    public function test_deletes_entity_lists()
    {
        $database = $this->buildDatabase();
        $database->expects($this->any())->method('delete');

        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);

        $entities = [
            $repository->loadEntity(1),
            $repository->loadEntity(2),
        ];

        $entities = $repository->deleteList($entities);

        $this->assertFalse($entities[0]->exists());
        $this->assertFalse($entities[1]->exists());
    }

    public function test_deletes_all()
    {
        $database = $this->buildDatabase();
        $database->expects($this->once())->method('delete');

        $definition = $this->buildDefinition();
        $factory = new DefaultEntityFactory();

        $repository = new DefaultRepository($definition, $factory, $database, false);
        $repository->deleteAll();
    }
}
