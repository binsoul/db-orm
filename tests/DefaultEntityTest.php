<?php

namespace BinSoul\Test\Db\Orm;

use BinSoul\Db\Orm\DefaultEntity;

class DefaultEntityTest extends \PHPUnit_Framework_TestCase
{
    public function test_indicates_existance()
    {
        $entity = new DefaultEntity(1, []);
        $this->assertTrue($entity->exists());

        $entity = new DefaultEntity(null, []);
        $this->assertFalse($entity->exists());
    }
}
