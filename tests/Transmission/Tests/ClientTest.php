<?php

namespace Transmission\Tests;

use Buzz\Exception\NetworkException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Transmission\Client;
use Transmission\Exception\ClientException;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Transmission\Client
     */
    protected $client;

    protected $curlMock;

    protected function setUp(): void
    {
        $this->client = new Client();

        $this->curlMock = $this->getMockBuilder("Buzz\Client\Curl")
            ->setConstructorArgs([new Psr17Factory()])
            ->getMock();
        $this->client->setClient($this->curlMock);
    }

    public function testShouldHaveDefaultScheme()
    {
        $this->assertEquals('http', $this->client->getScheme());
    }

    public function testSetScheme()
    {
        $expected = 'https';

        $this->client->setScheme($expected);
        $this->assertEquals($expected, $this->client->getScheme());
    }

    public function testShouldHaveDefaultHost()
    {
        $this->assertEquals('localhost', $this->client->getHost());
    }

    public function testSetHost()
    {
        $expected = 'domain.com';

        $this->client->setHost($expected);
        $this->assertEquals($expected, $this->client->getHost());
    }

    public function testShouldHaveDefaultPort()
    {
        $this->assertEquals(9091, $this->client->getPort());
    }

    public function testSetPort()
    {
        $expected = 80;

        $this->client->setPort($expected);
        $this->assertEquals($expected, $this->client->getPort());
    }

    public function testSetPath()
    {
        $expected = '/foo/bar';

        $this->client->setPath($expected);
        $this->assertEquals($expected, $this->client->getPath());
    }

    public function testShouldHaveNoTokenOnInstantiation()
    {
        $this->assertEmpty($this->client->getToken());
    }

    public function testShouldHaveDefaultClient()
    {
        $this->assertInstanceOf('Buzz\Client\Curl', $this->client->getClient());
    }

    public function testShouldGenerateDefaultUrl()
    {
        $this->assertEquals('http://localhost:9091', $this->client->getUrl());
    }

    public function testShouldMakeApiCall()
    {
        $this->curlMock->expects($this->once())
            ->method('sendRequest')
            ->with($this->isInstanceOf('Nyholm\Psr7\Request'))
            ->willReturn(new \Nyholm\Psr7\Response(200, [], '{}'));

        $response = $this->client->call('foo', ['bar' => 'baz']);

        $this->assertInstanceOf('stdClass', $response);
    }

    public function testShouldAuthenticate()
    {
        $this->curlMock->expects($this->once())
            ->method('sendRequest')
            ->with($this->isInstanceOf('Nyholm\Psr7\Request'))
            ->willReturn(new \Nyholm\Psr7\Response(200, [], '{}'));

        $this->client->authenticate('foo', 'bar');
        $response = $this->client->call('foo', ['bar' => 'baz']);

        $this->assertInstanceOf('stdClass', $response);
    }

    public function testShouldThrowExceptionOnExceptionDuringApiCall()
    {
        $this->curlMock->method('sendRequest')
            ->with($this->isInstanceOf('Nyholm\Psr7\Request'))
            ->will($this->throwException(
                new NetworkException(
                    new \Nyholm\Psr7\Request('GET', ''),
                    'Could not connect to Transmission'
                )
            ));

        $this->expectException(NetworkException::class);
        $this->expectExceptionMessage('Could not connect to Transmission');
        $this->expectExceptionCode(0);

        $this->client->call('foo', []);
    }

    public function testShouldThrowExceptionOnUnexpectedStatusCode()
    {
        $this->curlMock->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new \Nyholm\Psr7\Response(500));

        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Unexpected response received from Transmission');
        $this->expectExceptionCode(500);

        $this->client->call('foo', []);
    }

    public function testShouldThrowExceptionOnAccessDenied()
    {
        $this->curlMock->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new \Nyholm\Psr7\Response(401));

        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Access to Transmission requires authentication');
        $this->expectExceptionCode(401);

        $this->client->call('foo', []);
    }

    public function testShouldHandle409ResponseWhenMakingAnApiCall()
    {
        $this->curlMock->expects($this->exactly(2))
            ->method('sendRequest')
            ->willReturnOnConsecutiveCalls(
                new \Nyholm\Psr7\Response(409, ['X-Transmission-Session-Id' => 'foo']),
                new \Nyholm\Psr7\Response(200, [], '{}'),
            );

        $this->client->call('foo', []);
    }
}
