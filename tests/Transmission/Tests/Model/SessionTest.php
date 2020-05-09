<?php

namespace Transmission\Tests\Model;

use Transmission\Model\Session;
use Transmission\Util\PropertyMapper;

class SessionTest extends \PHPUnit\Framework\TestCase
{
    protected $session;

    public function setUp(): void
    {
        $this->session    = new Session();
        $this->mockClient = $this->getMockBuilder('Transmission\Client')
                                 ->getMock();
    }

    public function testShouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->session);
    }

    public function testShouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->session->getMapping());
    }

    public function testShouldBeCreatedFromMapping()
    {
        $source = (object) [
            'alt-speed-down'               => 1,
            'alt-speed-enabled'            => true,
            'download-dir'                 => 'foo',
            'download-queue-enabled'       => true,
            'download-queue-size'          => 5,
            'incomplete-dir'               => 'bar',
            'incomplete-dir-enabled'       => true,
            'script-torrent-done-filename' => 'baz',
            'script-torrent-done-enabled'  => true,
            'seedRatioLimit'               => 3.14,
            'seedRatioLimited'             => true,
            'seed-queue-size'              => 5,
            'seed-queue-enabled'           => true,
            'speed-limit-down'             => 100,
            'speed-limit-down-enabled'     => true,
            'speed-limit-up'               => 100,
            'speed-limit-up-enabled'       => true,
        ];

        PropertyMapper::map($this->session, $source);

        $this->assertEquals(1, $this->session->getAltSpeedDown());
        $this->assertTrue($this->session->isAltSpeedEnabled());
        $this->assertEquals('foo', $this->session->getDownloadDir());
        $this->assertEquals(5, $this->session->getDownloadQueueSize());
        $this->assertTrue($this->session->isDownloadQueueEnabled());
        $this->assertEquals('bar', $this->session->getIncompleteDir());
        $this->assertTrue($this->session->isIncompleteDirEnabled());
        $this->assertEquals('baz', $this->session->getTorrentDoneScript());
        $this->assertTrue($this->session->isTorrentDoneScriptEnabled());
        $this->assertEquals(3.14, $this->session->getSeedRatioLimit());
        $this->assertTrue($this->session->isSeedRatioLimited());
        $this->assertEquals(5, $this->session->getSeedQueueSize());
        $this->assertTrue($this->session->isSeedQueueEnabled());
        $this->assertEquals(100, $this->session->getDownloadSpeedLimit());
        $this->assertTrue($this->session->isDownloadSpeedLimitEnabled());
        $this->assertEquals(100, $this->session->getUploadSpeedLimit());
        $this->assertTrue($this->session->isUploadSpeedLimitEnabled());
    }

    public function testShouldSave()
    {
        $expected = [
            'alt-speed-down'               => 1,
            'alt-speed-enabled'            => true,
            'download-dir'                 => 'foo',
            'download-queue-enabled'       => true,
            'download-queue-size'          => 5,
            'incomplete-dir'               => 'bar',
            'incomplete-dir-enabled'       => true,
            'script-torrent-done-filename' => 'baz',
            'script-torrent-done-enabled'  => true,
            'seedRatioLimit'               => 3.14,
            'seedRatioLimited'             => true,
            'seed-queue-size'              => 5,
            'seed-queue-enabled'           => true,
            'speed-limit-down'             => 100,
            'speed-limit-down-enabled'     => true,
            'speed-limit-up'               => 100,
            'speed-limit-up-enabled'       => true,
        ];

        PropertyMapper::map($this->session, (object) $expected);

        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('session-set', $expected)
            ->will($this->returnCallback(function () {
                return (object) [
                    'result' => 'success',
                ];
            }));

        $this->session->setClient($this->mockClient);
        $this->session->save();
    }
}
