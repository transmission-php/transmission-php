<?php

namespace Transmission\Tests\Model;

class AbstractModelTest extends \PHPUnit\Framework\TestCase
{
    protected $model;

    public function setUp(): void
    {
        $this->model = $this->getMockForAbstractClass('Transmission\Model\AbstractModel');
    }

    public function testShouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->model);
    }

    public function testShouldHaveEmptyMappingByDefault()
    {
        $this->assertEmpty($this->model->getMapping());
    }

    public function testShouldHaveNoClientByDefault()
    {
        $this->assertNull($this->model->getClient());
    }

    public function testShouldHaveClientIfSetByUser()
    {
        $client = new \Transmission\Client();

        $this->model->setClient($client);
        $this->assertEquals($client, $this->model->getClient());
    }
}
