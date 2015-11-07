<?php

namespace BinSoul\Db\Orm;

use BinSoul\Db\Definition\Column;

/**
 * Provides information about a property of an entity.
 */
interface PropertyDefinition
{
    /**
     * Returns the associated database column.
     *
     * @return Column
     */
    public function getColumn();
}
