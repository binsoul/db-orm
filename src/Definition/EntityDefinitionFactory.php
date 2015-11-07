<?php

namespace BinSoul\Db\Orm\Definition;

use BinSoul\Db\Orm\EntityDefinition;
use BinSoul\Db\Orm\PropertyDefinition;

/**
 * Builds instances of the {@see EntityDefinition} interface.
 */
interface EntityDefinitionFactory
{
    /**
     * @param string               $entityClass
     * @param string               $tableName
     * @param PropertyDefinition[] $properties
     * @param string               $identityColumn
     *
     * @return EntityDefinition
     */
    public function build($entityClass, $tableName, array $properties, $identityColumn = 'id');
}
