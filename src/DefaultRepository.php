<?php

namespace BinSoul\Db\Orm;

use BinSoul\Db\Database;

/**
 * Provides a default implementation of the {@see Repository} interface.
 */
class DefaultRepository implements Repository
{
    /** @var string */
    private $entityClass;
    /** @var string */
    private $tableName;
    /** @var string */
    private $identityColumn;
    /** @var mixed[] */
    private $initialData;
    /** @var string */
    private $columns;

    /** @var EntityDefinition */
    protected $entityDefinition;
    /** @var EntityFactory */
    protected $entityFactory;
    /** @var Database */
    protected $database;
    /** @var bool */
    protected $forceWriteConnection;

    /**
     * Constructs an instance of this class.
     *
     * @param EntityDefinition $definition           definition of the returned entities
     * @param EntityFactory    $entityFactory
     * @param Database         $database
     * @param bool             $forceWriteConnection
     */
    public function __construct(
        EntityDefinition $definition,
        EntityFactory $entityFactory,
        Database $database,
        $forceWriteConnection
    ) {
        $this->entityDefinition = $definition;
        $this->entityFactory = $entityFactory;
        $this->database = $database;
        $this->forceWriteConnection = $forceWriteConnection;

        $this->entityClass = $definition->getEntityClass();
        $this->tableName = $definition->getTableName();
        $this->identityColumn = $definition->getIdentityColumnName();
        $this->initialData = $definition->getInitialData();
        $this->columns = implode(',', array_merge([$this->identityColumn], array_keys($this->initialData)));
    }

    public function newEntity()
    {
        return $this->entityFactory->build($this->entityClass, null, $this->initialData);
    }

    public function loadEntity($entityID)
    {
        if ($entityID < 1) {
            return $this->newEntity();
        }

        return $this->findEntity($this->identityColumn.'=?', [$entityID]);
    }

    public function loadList(array $entityIDs)
    {
        if (count($entityIDs) == 0) {
            return [];
        }

        return $this->findAll($this->identityColumn.' IN (...?)', [$entityIDs]);
    }

    public function loadAll()
    {
        $statement = 'SELECT '.$this->columns.' FROM '.$this->tableName;
        $result = $this->database->execute($statement, [], $this->forceWriteConnection);

        return $this->buildEntitiesFromRows($result->all());
    }

    public function saveEntity(Entity $entity)
    {
        if ($entity->exists()) {
            return $this->updateEntity($entity);
        }

        return $this->insertEntity($entity);
    }

    public function saveList(array $entities)
    {
        $result = [];
        foreach ($entities as $index => $entity) {
            $result[$index] = $this->saveEntity($entity);
        }

        return $result;
    }

    public function deleteEntity(Entity $entity)
    {
        if (!$entity->exists()) {
            return clone $entity;
        }

        $this->database->delete($this->tableName, $this->identityColumn.'=?', [$entity->getId()]);

        return $this->entityFactory->build($this->entityClass, null, $entity->getData());
    }

    public function deleteList(array $entities)
    {
        $result = [];
        foreach ($entities as $index => $entity) {
            $result[$index] = $this->deleteEntity($entity);
        }

        return $result;
    }

    public function deleteAll()
    {
        $this->database->delete($this->tableName);
    }

    /**
     * Builds an entity from the given row.
     *
     * @param mixed[] $row
     *
     * @return Entity
     */
    protected function buildEntityFromRow(array $row)
    {
        $id = $row[$this->identityColumn];
        unset($row[$this->identityColumn]);

        return $this->entityFactory->build($this->entityClass, $id, $row);
    }

    /**
     * Builds entities from the given rows.
     *
     * @param mixed[][] $rows
     *
     * @return Entity[]
     */
    protected function buildEntitiesFromRows(array $rows)
    {
        $result = [];
        foreach ($rows as $row) {
            $id = $row[$this->identityColumn];
            unset($row[$this->identityColumn]);

            $result[] = $this->entityFactory->build($this->entityClass, $id, $row);
        }

        return $result;
    }

    /**
     * Finds an entity.
     *
     * @param string  $condition
     * @param mixed[] $parameters
     *
     * @return Entity
     */
    protected function findEntity($condition, array $parameters = [])
    {
        $statement = 'SELECT '.$this->columns.' FROM '.$this->tableName.' WHERE '.$condition;
        $result = $this->database->execute($statement, $parameters, $this->forceWriteConnection);

        return $this->buildEntityFromRow($result->row());
    }

    /**
     * Finds a list of entities.
     *
     * @param string  $condition
     * @param mixed[] $parameters
     *
     * @return Entity[]
     */
    protected function findAll($condition, array $parameters = [])
    {
        $statement = 'SELECT '.$this->columns.' FROM '.$this->tableName.' WHERE '.$condition;
        $result = $this->database->execute($statement, $parameters, $this->forceWriteConnection);

        return $this->buildEntitiesFromRows($result->all());
    }

    /**
     * Inserts entity data into the database.
     *
     * @param Entity $entity
     *
     * @return Entity
     */
    protected function insertEntity(Entity $entity)
    {
        $data = $entity->getData();
        $result = $this->database->insert($this->tableName, $entity->getData());

        return $this->entityFactory->build($this->entityClass, $result->autoIncrementID(), $data);
    }

    /**
     * Updates entity data in the database.
     *
     * @param Entity $entity
     *
     * @return Entity
     */
    protected function updateEntity(Entity $entity)
    {
        $this->database->update($this->tableName, $entity->getData(), $this->identityColumn.'=?', [$entity->getId()]);

        return clone $entity;
    }
}
