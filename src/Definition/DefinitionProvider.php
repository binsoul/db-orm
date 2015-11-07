<?php

namespace BinSoul\Db\Orm\Definition;

use BinSoul\Db\Orm\EntityDefinition;

/**
 * Provides access to entity definitions.
 */
interface DefinitionProvider
{
    /**
     * Returns a definition for the given entity class.
     *
     * @param string $entityClass
     *
     * @return EntityDefinition|null
     */
    public function define($entityClass);
}
