<?php

namespace BinSoul\Db\Orm\Definition;

use BinSoul\Db\Definition\DataType;
use BinSoul\Db\Definition\DataType\BooleanType;
use BinSoul\Db\Definition\DataType\CharType;
use BinSoul\Db\Definition\DataType\DatetimeType;
use BinSoul\Db\Definition\DataType\DateType;
use BinSoul\Db\Definition\DataType\DecimalType;
use BinSoul\Db\Definition\DataType\IntegerType;
use BinSoul\Db\Definition\DataType\TimeType;
use BinSoul\Db\Definition\DataType\VarcharType;

/**
 * Provides a default implementation of the {@see DataTypeFactory} interface.
 */
class DefaultDataTypeFactory implements DataTypeFactory
{
    /** @var DataType */
    private $identityType;

    /**
     * Constructs an instance of this class.
     *
     * @param DataType $identityType data type for identity columns
     */
    public function __construct(DataType $identityType = null)
    {
        $this->identityType = $identityType;
        if ($this->identityType === null) {
            $this->identityType = new IntegerType();
        }
    }

    public function build($type, array $options)
    {
        switch ($type) {
            case 'identity':
                return $this->identityType;
            case 'entity':
                return $this->identityType;
            case 'integer':
                return new IntegerType();
            case 'string':
                return new VarcharType($options['length']);
            case 'char':
                return new CharType($options['length']);
            case 'decimal':
                return new DecimalType($options['precision'], $options['scale']);
            case 'boolean':
                return new BooleanType();
            case 'datetime':
                return new DatetimeType();
            case 'date':
                return new DateType();
            case 'time':
                return new TimeType();

            default:
                throw new \InvalidArgumentException(sprintf('Unknown type "%s" given.', $type));
        }
    }
}
