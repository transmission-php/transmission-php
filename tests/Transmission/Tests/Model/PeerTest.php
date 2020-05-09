<?php

namespace Transmission\Tests\Model;

use Transmission\Model\Peer;
use Transmission\Util\PropertyMapper;

class PeerTest extends \PHPUnit\Framework\TestCase
{
    protected $peer;

    public function setUp(): void
    {
        $this->peer = new Peer();
    }

    public function testShouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->peer);
    }

    public function testShouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->peer->getMapping());
    }

    public function testShouldBeCreatedFromMapping()
    {
        $source = (object) [
            'address'            => 'foo',
            'clientName'         => 'foo',
            'clientIsChoked'     => false,
            'clientIsInterested' => true,
            'flagStr'            => 'foo',
            'isDownloadingFrom'  => false,
            'isEncrypted'        => true,
            'isIncoming'         => false,
            'isUploadingTo'      => true,
            'isUTP'              => false,
            'peerIsChoked'       => true,
            'peerIsInterested'   => false,
            'port'               => 3000,
            'progress'           => 10.5,
            'rateToClient'       => 1000,
            'rateFromClient'     => 10000,
        ];

        PropertyMapper::map($this->peer, $source);

        $this->assertEquals('foo', $this->peer->getAddress());
        $this->assertEquals('foo', $this->peer->getClientName());
        $this->assertFalse($this->peer->isClientChoked());
        $this->assertTrue($this->peer->isClientInterested());
        $this->assertFalse($this->peer->isDownloading());
        $this->assertTrue($this->peer->isEncrypted());
        $this->assertFalse($this->peer->isIncoming());
        $this->assertTrue($this->peer->isUploading());
        $this->assertFalse($this->peer->isUtp());
        $this->assertTrue($this->peer->isPeerChoked());
        $this->assertFalse($this->peer->isPeerInterested());
        $this->assertEquals(3000, $this->peer->getPort());
        $this->assertEquals(10.5, $this->peer->getProgress());
        $this->assertEquals(1000, $this->peer->getUploadRate());
        $this->assertEquals(10000, $this->peer->getDownloadRate());
    }
}
