<?php

namespace BinSoul\Db\Orm;

/**
 * Provides methods to retrieve and to persist entities or lists of entities.
 */
interface Repository
{
    /**
     * Creates an entity with default data.
     *
     * @return Entity
     */
    public function newEntity();

    /**
     * Loads an entity.
     *
     * @param int|string $entityID
     *
     * @return Entity
     */
    public function loadEntity($entityID);

    /**
     * Loads a list of entities.
     *
     * @param int[]|string[] $entityIDs
     *
     * @return Entity[]
     */
    public function loadList(array $entityIDs);

    /**
     * Loads all entities.
     *
     * @return Entity[]
     */
    public function loadAll();

    /**
     * Saves an entity.
     *
     * @param Entity $entity
     *
     * @return Entity
     */
    public function saveEntity(Entity $entity);

    /**
     * Saves a list of entities.
     *
     * @param Entity[] $entities
     *
     * @return Entity[]
     */
    public function saveList(array $entities);

    /**
     * Deletes an entity.
     *
     * @param Entity $entity
     *
     * @return Entity
     */
    public function deleteEntity(Entity $entity);

    /**
     * Deletes a list of entities.
     *
     * @param Entity[] $entities
     *
     * @return Entity[]
     */
    public function deleteList(array $entities);

    /**
     * Deletes all entities.
     */
    public function deleteAll();
}
