<?php

namespace BinSoul\Db\Orm;

use BinSoul\Common\IdentifiableDataObject;

/**
 * Provides a default implementation of the {@see Entity} interface.
 */
class DefaultEntity implements Entity
{
    use IdentifiableDataObject;

    public function exists()
    {
        return $this->objectId !== null;
    }
}
