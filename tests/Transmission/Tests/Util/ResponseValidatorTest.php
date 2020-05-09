<?php

namespace Transmission\Tests\Util;

use Transmission\Util\ResponseValidator;

class ResponseValidatorTest extends \PHPUnit\Framework\TestCase
{
    protected $validator;

    public function setUp(): void
    {
        $this->validator = new ResponseValidator();
    }

    public function testShouldThrowExceptionOnMissingResultField()
    {
        $response = (object) [];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response received from Transmission');

        $this->validator->validate('', $response);
    }

    public function testShouldThrowExceptionOnErrorResultField()
    {
        $response = (object) ['result' => 'error'];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('An error occured: "error"');

        $this->validator->validate('', $response);
    }

    public function testShouldThrowNoExceptionOnValidTorrentGetResponse()
    {
        $response = (object) [
            'result'    => 'success',
            'arguments' => (object) [
                'torrents' => [
                    (object) ['foo' => 'bar'],
                ],
            ],
        ];

        $expected  = [(object) ['foo' => 'bar']];
        $container = $this->validator->validate('torrent-get', $response);
        $this->assertEquals($expected, $container);
    }

    public function testShouldThrowExceptionOnMissingArgumentsInTorrentGetResponse()
    {
        $response = (object) ['result' => 'success'];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response received from Transmission');

        $this->validator->validate('torrent-get', $response);
    }

    public function testShouldThrowExceptionOnMissingTorrentArgumentInTorrentGetResponse()
    {
        $response = (object) ['result' => 'success', 'arguments' => (object) []];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response received from Transmission');

        $this->validator->validate('torrent-get', $response);
    }

    public function testShouldThrowNoExceptionOnValidTorrentAddResponse()
    {
        $response = (object) [
            'result'    => 'success',
            'arguments' => (object) [
                'torrent-added' => (object) [
                    'foo' => 'bar',
                ],
            ],
        ];

        $expected  = (object) ['foo' => 'bar'];
        $container = $this->validator->validate('torrent-add', $response);
        $this->assertEquals($expected, $container);
    }

    public function testShouldThrowNoExceptionOnValidSessionGetResponse()
    {
        $response = (object) [
            'result'    => 'success',
            'arguments' => (object) [
                'foo' => 'bar',
            ],
        ];

        $expected  = (object) ['foo' => 'bar'];
        $container = $this->validator->validate('session-get', $response);
        $this->assertEquals($expected, $container);
    }

    public function testShouldThrowExceptionOnMissingArgumentsInSessionGetResponse()
    {
        $response = (object) ['result' => 'success'];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response received from Transmission');

        $this->validator->validate('session-get', $response);
    }

    public function testShouldThrowExceptionOnMissingArgumentsSessionGetResponse()
    {
        $response = (object) ['result' => 'success'];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response received from Transmission');

        $this->validator->validate('session-get', $response);
    }

    public function testShouldThrowExceptionOnMissingArgumentsInTorrentAddResponse()
    {
        $response = (object) ['result' => 'success'];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response received from Transmission');

        $this->validator->validate('torrent-add', $response);
    }

    public function testShouldThrowExceptionOnMissingTorrentFieldArgumentInTorrentAddResponse()
    {
        $response = (object) ['result' => 'success', 'arguments' => (object) []];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response received from Transmission');

        $this->validator->validate('torrent-add', $response);
    }

    public function testShouldThrowExceptionOnEmptyTorrentFieldInTorrentAddResponse()
    {
        $response = (object) ['result' => 'success', 'arguments' => (object) ['torrent-added' => []]];

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid response received from Transmission');

        $this->validator->validate('torrent-add', $response);
    }

    public function testShouldThrowNoExceptionOnValidOtherResponses()
    {
        $response = (object) ['result' => 'success'];

        $container = $this->validator->validate('torrent-remove', $response);
        $this->assertNull($container);
    }
}
