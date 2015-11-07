<?php

namespace BinSoul\Db\Orm;

/**
 * Builds instances of the {@see Entity} interface.
 */
interface EntityFactory
{
    /**
     * @param string          $class
     * @param int|string|null $id
     * @param array           $data
     *
     * @return Entity
     */
    public function build($class, $id, array $data);
}
