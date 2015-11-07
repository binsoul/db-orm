<?php

namespace BinSoul\Db\Orm;

/**
 * Provides a default implementation of the {@see EntityDefinition} interface.
 */
class DefaultEntityDefinition implements EntityDefinition
{
    /** @var string */
    private $entityClass;
    /** @var string */
    private $tableName;
    /** @var string */
    private $identityColumn = 'id';
    /** @var PropertyDefinition[] */
    private $properties;

    /**
     * Constructs an instance of this class.
     *
     * @param string               $entityClass
     * @param string               $tableName
     * @param PropertyDefinition[] $properties
     * @param string               $identityColumn
     */
    public function __construct($entityClass, $tableName, array $properties, $identityColumn = 'id')
    {
        $this->entityClass = $entityClass;
        $this->tableName = $tableName;
        $this->properties = $properties;
        $this->identityColumn = $identityColumn;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     *
     * @return static
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentityColumnName()
    {
        return $this->identityColumn;
    }

    /**
     * @param string $identityColumn
     *
     * @return static
     */
    public function setIdentityColumnName($identityColumn)
    {
        $this->identityColumn = $identityColumn;

        return $this;
    }

    /**
     * @return PropertyDefinition[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param string $columnName
     *
     * @return PropertyDefinition
     */
    public function findProperty($columnName)
    {
        foreach ($this->properties as $property) {
            if ($property->getColumn()->getName() == $columnName) {
                return $property;
            }
        }

        return;
    }

    /**
     * Adds a property to the internal list.
     *
     * @param PropertyDefinition $property
     */
    public function addProperty(PropertyDefinition $property)
    {
        $this->properties[] = $property;
    }

    /**
     * @return mixed[]
     */
    public function getInitialData()
    {
        $result = [];
        foreach ($this->properties as $property) {
            $column = $property->getColumn();
            if ($column->getName() == $this->identityColumn) {
                continue;
            }

            $result[$column->getName()] = $column->getInitialValue();
        }

        return $result;
    }
}
