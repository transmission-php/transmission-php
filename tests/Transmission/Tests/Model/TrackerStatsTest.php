<?php

namespace Transmission\Tests\Model;

use Transmission\Model\TrackerStats;
use Transmission\Util\PropertyMapper;

class TrackerStatsTest extends \PHPUnit\Framework\TestCase
{
    protected $trackerStats;

    public function setUp(): void
    {
        $this->trackerStats = new TrackerStats();
    }

    public function testShouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->trackerStats);
    }

    public function testShouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->trackerStats->getMapping());
    }

    public function testShouldBeCreatedFromMapping()
    {
        $source = (object) [
            'host'               => 'test',
            'leecherCount'       => 1,
            'seederCount'        => 2,
            'lastScrapeResult'   => 'foo',
            'lastAnnounceResult' => 'bar',
        ];

        PropertyMapper::map($this->trackerStats, $source);

        $this->assertEquals('test', $this->trackerStats->getHost());
        $this->assertEquals(1, $this->trackerStats->getLeecherCount());
        $this->assertEquals(2, $this->trackerStats->getSeederCount());
        $this->assertEquals('foo', $this->trackerStats->getLastScrapeResult());
        $this->assertEquals('bar', $this->trackerStats->getLastAnnounceResult());
    }
}
