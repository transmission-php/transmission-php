<?php

namespace Transmission\Tests\Model;

use Transmission\Model\Tracker;
use Transmission\Util\PropertyMapper;

class TrackerTest extends \PHPUnit\Framework\TestCase
{
    protected $tracker;

    public function setUp(): void
    {
        $this->tracker = new Tracker();
    }

    public function testShouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->tracker);
    }

    public function testShouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->tracker->getMapping());
    }

    public function testShouldBeCreatedFromMapping()
    {
        $source = (object) [
            'id'       => 1,
            'tier'     => 1,
            'scrape'   => 'foo',
            'announce' => 'bar',
        ];

        PropertyMapper::map($this->tracker, $source);

        $this->assertEquals(1, $this->tracker->getId());
        $this->assertEquals(1, $this->tracker->getTier());
        $this->assertEquals('foo', $this->tracker->getScrape());
        $this->assertEquals('bar', $this->tracker->getAnnounce());
    }
}
