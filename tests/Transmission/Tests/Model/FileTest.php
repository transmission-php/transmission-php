<?php

namespace Transmission\Tests\Model;

use Transmission\Model\File;
use Transmission\Util\PropertyMapper;

class FileTest extends \PHPUnit\Framework\TestCase
{
    protected $file;

    public function setUp(): void
    {
        $this->file = new File();
    }

    public function testShouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->file);
    }

    public function testShouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->file->getMapping());
    }

    public function testShouldBeCreatedFromMapping()
    {
        $source = (object) [
            'name'           => 'foo',
            'length'         => 100,
            'bytesCompleted' => 10,
        ];

        PropertyMapper::map($this->file, $source);

        $this->assertEquals('foo', $this->file->getName());
        $this->assertEquals(100, $this->file->getSize());
        $this->assertEquals(10, $this->file->getCompleted());
        $this->assertFalse($this->file->isDone());
    }

    public function testShouldConvertToString()
    {
        $this->file->setName('foo');

        $this->assertIsString((string) $this->file);
        $this->assertEquals('foo', $this->file);
    }
}
