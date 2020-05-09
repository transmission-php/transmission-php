<?php

namespace Transmission\Tests;

use Transmission\Exception\ClientException;
use Transmission\Model\Torrent;
use Transmission\Transmission;

class TransmissionTest extends \PHPUnit\Framework\TestCase
{
    protected $transmission;

    public function setUp(): void
    {
        $this->transmission = new Transmission();
        $this->mockSession  = $this->getMockBuilder('Transmission\Model\Session')
            ->getMock();
        $this->mockClient = $this->getMockBuilder('Transmission\Client')
            ->getMock();
    }

    public function testShouldHaveDefaultHost()
    {
        $this->assertEquals('localhost', $this->transmission->getClient()->getHost());
    }

    public function testShouldGetAllTorrentsInDownloadQueue()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnCallback(function ($method, $arguments) {
                return (object) [
                    'result'    => 'success',
                    'arguments' => (object) [
                        'torrents' => [
                            (object) [],
                            (object) [],
                            (object) [],
                        ],
                    ],
                ];
            }));

        $this->transmission->setClient($this->mockClient);

        $torrents = $this->transmission->all();

        $this->assertCount(3, $torrents);
    }

    public function testShouldGetTorrentById()
    {
        $that   = $this;

        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnCallback(function ($method, $arguments) use ($that) {
                $that->assertEquals(1, $arguments['ids'][0]);

                return (object) [
                    'result'    => 'success',
                    'arguments' => (object) [
                        'torrents' => [
                            (object) [],
                        ],
                    ],
                ];
            }));

        $this->transmission->setClient($this->mockClient);

        $torrent = $this->transmission->get(1);

        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
    }

    public function testShouldThrowExceptionWhenTorrentIsNotFound()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnCallback(function ($method, $arguments) {
                return (object) [
                    'result'    => 'success',
                    'arguments' => (object) [
                        'torrents' => [],
                    ],
                ];
            }));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Torrent with ID 1 not found');

        $this->transmission->setClient($this->mockClient);
        $this->transmission->get(1);
    }

    public function testShouldAddTorrentByFilename()
    {
        $that   = $this;

        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-add')
            ->will($this->returnCallback(function ($method, $arguments) use ($that) {
                $that->assertArrayHasKey('filename', $arguments);

                return (object) [
                    'result'    => 'success',
                    'arguments' => (object) [
                        'torrent-added' => (object) [true],
                    ],
                ];
            }));

        $this->transmission->setClient($this->mockClient);

        $torrent = $this->transmission->add('foo');
        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
    }

    public function testShouldAddTorrentByMetainfo()
    {
        $that   = $this;

        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-add')
            ->will($this->returnCallback(function ($method, $arguments) use ($that) {
                $that->assertArrayHasKey('metainfo', $arguments);

                return (object) [
                    'result'    => 'success',
                    'arguments' => (object) [
                        'torrent-added' => (object) [true],
                    ],
                ];
            }));

        $this->transmission->setClient($this->mockClient);

        $torrent = $this->transmission->add('foo', true);
        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
    }

    public function testShouldHandleDuplicateTorrent()
    {
        $that   = $this;

        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-add')
            ->will($this->returnCallback(function ($method, $arguments) use ($that) {
                $that->assertArrayHasKey('metainfo', $arguments);

                return (object) [
                    'result'    => 'duplicate torrent',
                    'arguments' => (object) [
                        'torrent-duplicate' => (object) [true],
                    ],
                ];
            }));

        $this->transmission->setClient($this->mockClient);

        $torrent = $this->transmission->add('foo', true);
        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
    }

    public function testShouldGetSession()
    {
        $that   = $this;

        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('session-get')
            ->will($this->returnCallback(function ($method, $arguments) use ($that) {
                $that->assertEmpty($arguments);

                return (object) [
                    'result'    => 'success',
                    'arguments' => (object) [true],
                ];
            }));

        $this->transmission->setClient($this->mockClient);
        $session = $this->transmission->getSession();

        $this->assertInstanceOf('Transmission\Model\Session', $session);
    }

    public function testShouldGetSessionStats()
    {
        $that   = $this;

        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('session-stats')
            ->will($this->returnCallback(function ($method, $arguments) use ($that) {
                $that->assertEmpty($arguments);

                return (object) [
                    'result'    => 'success',
                    'arguments' => (object) [true],
                ];
            }));

        $this->transmission->setClient($this->mockClient);
        $stats = $this->transmission->getSessionStats();

        $this->assertInstanceOf('Transmission\Model\Stats\Session', $stats);
    }

    public function testShouldGetFreeSpace()
    {
        $that = $this;

        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('free-space')
            ->will($this->returnCallback(function ($method, $arguments) use ($that) {
                $that->assertArrayHasKey('path', $arguments);

                return (object) [
                    'result'    => 'success',
                    'arguments' => (object) [true],
                ];
            }));

        $this->transmission->setClient($this->mockClient);
        $freeSpace = $this->transmission->getFreeSpace('/');
        $this->assertInstanceOf('Transmission\Model\FreeSpace', $freeSpace);
    }

    public function testShouldStartDownload()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-start', ['ids' => [1]])
            ->will($this->returnCallback(function () {
                return (object) [
                    'result' => 'success',
                ];
            }));

        $torrent = new Torrent();
        $torrent->setId(1);

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);
        $transmission->start($torrent);
    }

    public function testShouldStartDownloadImmediately()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-start-now', ['ids' => [1]])
            ->will($this->returnCallback(function () {
                return (object) [
                    'result' => 'success',
                ];
            }));

        $torrent = new Torrent();
        $torrent->setId(1);

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);
        $transmission->start($torrent, true);
    }

    public function testShouldStopDownload()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-stop', ['ids' => [1]])
            ->will($this->returnCallback(function () {
                return (object) [
                    'result' => 'success',
                ];
            }));

        $torrent = new Torrent();
        $torrent->setId(1);

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);
        $transmission->stop($torrent);
    }

    public function testShouldVerifyDownload()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-verify', ['ids' => [1]])
            ->will($this->returnCallback(function () {
                return (object) [
                    'result' => 'success',
                ];
            }));

        $torrent = new Torrent();
        $torrent->setId(1);

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);
        $transmission->verify($torrent);
    }

    public function testShouldReannounceDownload()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-reannounce', ['ids' => [1]])
            ->will($this->returnCallback(function () {
                return (object) [
                    'result' => 'success',
                ];
            }));

        $torrent = new Torrent();
        $torrent->setId(1);

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);
        $transmission->reannounce($torrent);
    }

    public function testShouldRemoveDownloadWithoutRemovingLocalData()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-remove', ['ids' => [1]])
            ->will($this->returnCallback(function () {
                return (object) [
                    'result' => 'success',
                ];
            }));

        $torrent = new Torrent();
        $torrent->setId(1);

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);
        $transmission->remove($torrent);
    }

    public function testShouldRemoveDownloadWithRemovingLocalData()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('torrent-remove', ['ids' => [1], 'delete-local-data' => true])
            ->will($this->returnCallback(function () {
                return (object) [
                    'result' => 'success',
                ];
            }));

        $torrent = new Torrent();
        $torrent->setId(1);

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);
        $transmission->remove($torrent, true);
    }

    public function testShouldTellIfTransmissionRpcIsAvailable()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('', [])
            ->will($this->returnCallback(function () {
                return new \stdClass();
            }));

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);

        $this->assertTrue($transmission->isAvailable());
    }

    public function testShouldTellIfTransmissionRpcIsUnavailable()
    {
        $this->mockClient->expects($this->once())
            ->method('call')
            ->with('', [])
            ->will($this->returnCallback(function () {
                throw new ClientException('connection error', 0);
            }));

        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('connection error');
        $this->expectExceptionCode(0);

        $transmission = new Transmission();
        $transmission->setClient($this->mockClient);
        $transmission->isAvailable();
    }

    public function testShouldHaveDefaultPort()
    {
        $this->assertEquals(9091, $this->transmission->getClient()->getPort());
    }

    public function testShouldProvideFacadeForClient()
    {
        $this->mockClient->expects($this->once())
            ->method('setHost')
            ->with('example.org');

        $this->mockClient->expects($this->once())
            ->method('getHost')
            ->will($this->returnValue('example.org'));

        $this->mockClient->expects($this->once())
            ->method('setPort')
            ->with(80);

        $this->mockClient->expects($this->once())
            ->method('getPort')
            ->will($this->returnValue(80));

        $this->transmission->setClient($this->mockClient);
        $this->transmission->setHost('example.org');
        $this->transmission->setPort(80);

        $this->assertEquals('example.org', $this->transmission->getHost());
        $this->assertEquals(80, $this->transmission->getPort());
    }
}
