<?php

namespace BinSoul\Db\Orm;

/**
 * Provides a default implementation of the {@see EntityFactory} interface.
 */
class DefaultEntityFactory implements EntityFactory
{
    public function build($class, $id, array $data)
    {
        return new $class($id, $data);
    }
}
