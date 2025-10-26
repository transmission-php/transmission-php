<?php

namespace Transmission\Tests;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Transmission\Client;
use Transmission\Exception\ClientException;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Transmission\Client
     */
    protected $client;

    protected $mockHttpClient;

    protected function setUp(): void
    {
        // Create a mock HTTP client for testing
        $this->mockHttpClient = new MockHttpClient();

        $this->client = new Client();
        $this->client->setClient($this->mockHttpClient);
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
        $this->assertInstanceOf('Symfony\Contracts\HttpClient\HttpClientInterface', $this->client->getClient());
    }

    public function testShouldGenerateDefaultUrl()
    {
        $this->assertEquals('http://localhost:9091', $this->client->getUrl());
    }

    public function testShouldMakeApiCall()
    {
        // Create a mock response for the Symfony HTTP client
        $mockResponse = new MockResponse('{}', ['http_code' => 200]);
        $this->mockHttpClient = new MockHttpClient($mockResponse);
        $this->client->setClient($this->mockHttpClient);

        $response = $this->client->call('foo', ['bar' => 'baz']);

        $this->assertInstanceOf('stdClass', $response);
    }

    public function testShouldAuthenticate()
    {
        $mockResponse = new MockResponse('{}', ['http_code' => 200]);
        $this->mockHttpClient = new MockHttpClient($mockResponse);
        $this->client->setClient($this->mockHttpClient);

        $this->client->authenticate('foo', 'bar');
        $response = $this->client->call('foo', ['bar' => 'baz']);

        $this->assertInstanceOf('stdClass', $response);
    }

    public function testShouldThrowExceptionOnExceptionDuringApiCall()
    {
        // Create a mock HTTP client that will throw a transport exception
        $mockHttpClient = new MockHttpClient(function() {
            throw new \Symfony\Component\HttpClient\Exception\TransportException('Could not connect to Transmission');
        });
        $this->client->setClient($mockHttpClient);

        $this->expectException(\Transmission\Exception\ClientException::class);
        $this->expectExceptionMessage('Network error: Could not connect to Transmission');

        $this->client->call('foo', []);
    }

    public function testShouldThrowExceptionOnUnexpectedStatusCode()
    {
        // Create a mock response with 500 status code
        $mockResponse = new MockResponse('Internal Server Error', ['http_code' => 500]);
        $mockHttpClient = new MockHttpClient($mockResponse);
        $this->client->setClient($mockHttpClient);

        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('HTTP 500: Internal Server Error');

        $this->client->call('foo', []);
    }

    public function testShouldThrowExceptionOnAccessDenied()
    {
        // Create a mock response with 401 status code
        $mockResponse = new MockResponse('Unauthorized', ['http_code' => 401]);
        $mockHttpClient = new MockHttpClient($mockResponse);
        $this->client->setClient($mockHttpClient);

        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('HTTP 401: Unauthorized');

        $this->client->call('foo', []);
    }

    public function testShouldHandle409ResponseWhenMakingAnApiCall()
    {
        // Create mock responses: first 409 with session ID, then 200 success
        $mockResponses = [
            new MockResponse('', [
                'http_code' => 409,
                'response_headers' => ['x-transmission-session-id' => 'foo']
            ]),
            new MockResponse('{}', ['http_code' => 200])
        ];
        $mockHttpClient = new MockHttpClient($mockResponses);
        $this->client->setClient($mockHttpClient);

        $response = $this->client->call('foo', []);
        $this->assertInstanceOf('stdClass', $response);
    }
}
