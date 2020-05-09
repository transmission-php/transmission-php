<?php

namespace Transmission\Tests\Model;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Transmission\Model\Torrent;
use Transmission\Util\PropertyMapper;

class TorrentTest extends \PHPUnit\Framework\TestCase
{
    protected $torrent;

    public function setUp(): void
    {
        $this->torrent = new Torrent();
    }

    public function testShouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->torrent);
    }

    public function testShouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->torrent->getMapping());
    }

    public function testShouldBeCreatedFromMapping()
    {
        $source = (object) [
            'id'             => 1,
            'comment'        => 'a comment',
            'doneDate'       => 1589234242,
            'eta'            => 10,
            'sizeWhenDone'   => 10000,
            'name'           => 'foo',
            'hashString'     => 'bar',
            'status'         => 0,
            'isFinished'     => false,
            'isPrivate'      => false,
            'rateUpload'     => 10,
            'rateDownload'   => 100,
            'downloadDir'    => '/home/foo',
            'downloadedEver' => 1024000000,
            'uploadedEver'   => 1024000000000, // 1 Tb
            'files'          => [
                (object) [],
            ],
            'peers' => [
                (object) [],
                (object) [],
            ],
            'peersConnected' => 10,
            'startDate'      => 1427583510,
            'trackers'       => [
                (object) [],
                (object) [],
                (object) [],
            ],
            'trackerStats' => [
                (object) [],
                (object) [],
                (object) [],
            ],
        ];

        PropertyMapper::map($this->torrent, $source);

        $this->assertEquals(1, $this->torrent->getId());
        $this->assertEquals('a comment', $this->torrent->getComment());
        $this->assertEquals(1589234242, $this->torrent->getDoneDate());
        $this->assertEquals(10, $this->torrent->getEta());
        $this->assertEquals(10000, $this->torrent->getSize());
        $this->assertEquals('foo', $this->torrent->getName());
        $this->assertEquals('bar', $this->torrent->getHash());
        $this->assertEquals(0, $this->torrent->getStatus());
        $this->assertFalse($this->torrent->isFinished());
        $this->assertFalse($this->torrent->isPrivate());
        $this->assertEquals(10, $this->torrent->getUploadRate());
        $this->assertEquals(100, $this->torrent->getDownloadRate());
        $this->assertEquals('/home/foo', $this->torrent->getDownloadDir());
        $this->assertEquals(1024000000, $this->torrent->getDownloadedEver());
        $this->assertEquals(1024000000000, $this->torrent->getUploadedEver());
        $this->assertCount(1, $this->torrent->getFiles());
        $this->assertCount(2, $this->torrent->getPeers());
        $this->assertCount(3, $this->torrent->getTrackers());
    }

    public function testShouldBeDoneWhenFinishedFlagIsSet()
    {
        $this->torrent->setFinished(true);

        $this->assertTrue($this->torrent->isFinished());
    }

    public function testShouldBeDoneWhenPercentDoneIs100Percent()
    {
        $this->torrent->setPercentDone(1);

        $this->assertTrue($this->torrent->isFinished());
    }

    public function statusProvider()
    {
        return [
            [0, 'stopped'],
            [1, 'checking'],
            [2, 'checking'],
            [3, 'downloading'],
            [4, 'downloading'],
            [5, 'seeding'],
            [6, 'seeding'],
        ];
    }

    /**
     * @dataProvider statusProvider
     */
    public function testShouldHaveConvenienceMethods($status, $method)
    {
        $methods  = ['stopped', 'checking', 'downloading', 'seeding'];
        $accessor = PropertyAccess::createPropertyAccessor();
        $this->torrent->setStatus($status);

        $methods = array_filter($methods, function ($value) use ($method) {
            return $method !== $value;
        });

        $this->assertTrue($accessor->getValue($this->torrent, $method));
        foreach ($methods as $m) {
            $this->assertFalse($accessor->getValue($this->torrent, $m), $m);
        }
    }
}
