<?php

namespace BinSoul\Db\Orm;

/**
 * Provides information about an entity.
 */
interface EntityDefinition
{
    /**
     * Returns the class of the entity.
     *
     * @return string
     */
    public function getEntityClass();

    /**
     * Returns the table name of the entity.
     *
     * @return string
     */
    public function getTableName();

    /**
     * Returns the name of the column which identifies the entity.
     *
     * @return string
     */
    public function getIdentityColumnName();

    /**
     * Returns the properties of the entity.
     *
     * @return PropertyDefinition[]
     */
    public function getProperties();

    /**
     * Finds a property by the given column name.
     *
     * @param string $columnName
     *
     * @return PropertyDefinition
     */
    public function findProperty($columnName);

    /**
     * Returns data which can be used to initialize a new entity.
     *
     * @return mixed[]
     */
    public function getInitialData();
}
