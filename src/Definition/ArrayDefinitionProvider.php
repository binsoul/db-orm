<?php

namespace BinSoul\Db\Orm\Definition;

use BinSoul\Db\Definition\Column;

/**
 * Stores definitions for all entities in an array indexed by the entity class name.
 */
class ArrayDefinitionProvider implements DefinitionProvider
{
    /** @var mixed[] */
    protected static $entityDefaults = [
        'table' => '',
        'id' => 'id',
        'properties' => [],
    ];

    /** @var mixed[] */
    protected static $propertyDefaults = [
        'column' => '',
        'type' => '',
        'nullable' => false,
        'default' => null,
    ];

    /** @var mixed[] */
    private $definitions;
    /** @var DataTypeFactory */
    private $dataTypeFactory;
    /** @var EntityDefinitionFactory */
    private $entityFactory;
    /** @var PropertyDefinitionFactory */
    private $propertyFactory;

    /**
     * Constructs an instance of this class.
     *
     * @param mixed[]                   $definitions
     * @param DataTypeFactory           $dataTypeFactory
     * @param EntityDefinitionFactory   $entityFactory
     * @param PropertyDefinitionFactory $propertyFactory
     */
    public function __construct(
        array $definitions,
        DataTypeFactory $dataTypeFactory = null,
        EntityDefinitionFactory $entityFactory = null,
        PropertyDefinitionFactory $propertyFactory = null
    ) {
        $this->definitions = $definitions;

        $this->dataTypeFactory = $dataTypeFactory;
        if ($this->dataTypeFactory === null) {
            $this->dataTypeFactory = new DefaultDataTypeFactory();
        }

        $this->entityFactory = $entityFactory;
        if ($this->entityFactory === null) {
            $this->entityFactory = new DefaultEntityDefinitionFactory();
        }

        $this->propertyFactory = $propertyFactory;
        if ($this->propertyFactory == null) {
            $this->propertyFactory = new DefaultPropertyDefinitionFactory();
        }
    }

    public function define($entityClass)
    {
        if (!isset($this->definitions[$entityClass])) {
            return;
        }

        $entity = array_merge(self::$entityDefaults, $this->definitions[$entityClass]);

        $properties = [];
        foreach ($entity['properties'] as $data) {
            $data = array_merge(self::$propertyDefaults, $data);

            $dataType = $this->dataTypeFactory->build($data['type'], $data);

            $column = new Column($data['column'], $dataType, $data['nullable']);
            if ($data['default'] != null) {
                $column->setDefaultValue($data['default']);
            }

            $properties[] = $this->propertyFactory->build($column);
        }

        return $this->entityFactory->build($entityClass, $entity['table'], $properties, $entity['id']);
    }
}
