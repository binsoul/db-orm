<?php

namespace BinSoul\Db\Orm;

use BinSoul\Common\Equatable;
use BinSoul\Common\Nullable;
use BinSoul\Common\Identifiable;

/**
 * Represents an object built from the data of a database table row.
 */
interface Entity extends Identifiable, Equatable, Nullable
{
    /**
     * Constructs an instance.
     *
     * @param int|string|null $id
     * @param mixed[]         $data
     */
    public function __construct($id, array $data);

    /**
     * Returns the identifier the entity.
     *
     * @return int|string|null
     */
    public function getId();

    /**
     * Returns the data of the entity.
     *
     * @return mixed[]
     */
    public function getData();
}
