<?php

namespace Transmission\Tests\Util;

use Transmission\Util\PropertyMapper;

class PropertyMapperTest extends \PHPUnit\Framework\TestCase
{
    protected $mapper;

    public function setup(): void
    {
        $this->mapper = new PropertyMapper();
    }

    public function testShouldMapSourcesToModelWithMethodCall()
    {
        $source = (object) [
            'foo'    => 'this',
            'bar'    => 'that',
            'ba'     => 'thus',
            'unused' => false,
        ];

        $model = new \Transmission\Mock\Model();

        $this->mapper->map($model, $source);

        $this->assertEquals('this', $model->getFo());
        $this->assertEquals('that', $model->getBar());
        $this->assertNull($model->getUnused());
    }
}
