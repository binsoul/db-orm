<?php

namespace BinSoul\Db\Orm\Definition;

use BinSoul\Db\Definition\DataType;

/**
 * Builds instances of the {@see DataType} interface.
 */
interface DataTypeFactory
{
    /**
     * @param string $type
     * @param mixed  $options
     *
     * @return DataType
     */
    public function build($type, array $options);
}
