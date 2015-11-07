<?php

namespace BinSoul\Db\Orm\Definition;

use BinSoul\Db\Definition\Column;
use BinSoul\Db\Orm\PropertyDefinition;

/**
 * Builds instances of the {@see PropertyDefinition} interface.
 */
interface PropertyDefinitionFactory
{
    /**
     * @param Column $column
     *
     * @return PropertyDefinition
     */
    public function build(Column $column);
}
