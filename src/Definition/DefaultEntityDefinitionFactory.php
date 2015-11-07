<?php

namespace BinSoul\Db\Orm\Definition;

use BinSoul\Db\Orm\DefaultEntityDefinition;

/**
 * Provides a default implementation of the {@see EntityDefinitionFactory} interface.
 */
class DefaultEntityDefinitionFactory implements EntityDefinitionFactory
{
    public function build($entityClass, $tableName, array $properties, $identityColumn = 'id')
    {
        return new DefaultEntityDefinition($entityClass, $tableName, $properties, $identityColumn);
    }
}
