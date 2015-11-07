<?php

namespace BinSoul\Db\Orm\Definition;

use BinSoul\Db\Definition\Column;
use BinSoul\Db\Orm\DefaultPropertyDefinition;

/**
 * Provides a default implementation of the {@see PropertyDefinitionFactory} interface.
 */
class DefaultPropertyDefinitionFactory implements PropertyDefinitionFactory
{
    public function build(Column $column)
    {
        return new DefaultPropertyDefinition($column);
    }
}
