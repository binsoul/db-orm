<?php

namespace BinSoul\Db\Orm;

use BinSoul\Db\Definition\Column;

/**
 * Provides a default implementation of the {@see PropertyDefinition} interface.
 */
class DefaultPropertyDefinition implements PropertyDefinition
{
    /** @var Column */
    private $column;

    /**
     * Constructs an instance of this class.
     *
     * @param Column $column
     */
    public function __construct(Column $column)
    {
        $this->column = $column;
    }

    public function getColumn()
    {
        return $this->column;
    }
}
