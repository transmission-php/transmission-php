<?php

namespace Transmission;

use Buzz\Client\BuzzClientInterface;
use Buzz\Client\Curl;
use Buzz\Exception\NetworkException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use Transmission\Exception\ClientException;

/**
 * The Client class is used to make API calls to the Transmission server.
 */
class Client
{
    /**
     * @var string
     */
    const DEFAULT_SCHEME = 'http';

    /**
     * @var string
     */
    const DEFAULT_HOST = 'localhost';

    /**
     * @var int
     */
    const DEFAULT_PORT = 9091;

    /**
     * @var string
     */
    const DEFAULT_PATH = '/transmission/rpc';

    /**
     * @var string
     */
    const TOKEN_HEADER = 'X-Transmission-Session-Id';

    /**
     * @var string
     */
    protected $scheme = self::DEFAULT_SCHEME;

    /**
     * @var string
     */
    protected $host = self::DEFAULT_HOST;

    /**
     * @var int
     */
    protected $port = self::DEFAULT_PORT;

    /**
     * @var string
     */
    protected $path = self::DEFAULT_PATH;

    /**
     * @var string
     */
    protected $token = '';

    /**
     * @var BuzzClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $auth;

    public function __construct(?string $host = null, ?int $port = null, ?string $path = null, ?string $scheme = null)
    {
        $this->client = new Curl(new Psr17Factory());

        if ($scheme) {
            $this->setScheme($scheme);
        }
        if ($host) {
            $this->setHost($host);
        }
        if ($port) {
            $this->setPort($port);
        }
        if ($path) {
            $this->setPath($path);
        }
    }

    /**
     * Authenticate against the Transmission server.
     */
    public function authenticate(string $username, string $password): void
    {
        $this->auth = base64_encode($username . ':' . $password);
    }

    /**
     * Make an API call.
     *
     * @throws NetworkException
     */
    public function call(string $method, array $arguments): \stdClass
    {
        $request = $this->compose($method, $arguments);

        try {
            $response = $this->getClient()->sendRequest($request);
        } catch (NetworkException $e) {
            throw $e;
        }

        return $this->validateResponse($response, $method, $arguments);
    }

    /**
     * Get the URL used to connect to Transmission.
     */
    public function getUrl(): string
    {
        return sprintf(
            '%s://%s:%d',
            $this->getScheme(),
            $this->getHost(),
            $this->getPort()
        );
    }

    /**
     * Set the scheme of the Transmission server.
     */
    public function setScheme(string $scheme): void
    {
        $this->scheme = $scheme;
    }

    /**
     * Get the scheme of the Transmission server.
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * Set the hostname of the Transmission server.
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * Get the hostname of the Transmission server.
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Set the port the Transmission server is listening on.
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * Get the port the Transmission server is listening on.
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Set the path to Transmission server rpc api.
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * Get the path to Transmission server rpc api.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Set the CSRF-token of the Transmission client.
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Get the CSRF-token for the Transmission client.
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set the Buzz client used to connect to Transmission.
     */
    public function setClient(BuzzClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get the Buzz client used to connect to Transmission.
     */
    public function getClient(): BuzzClientInterface
    {
        return $this->client;
    }

    protected function compose(string $method, array $arguments): Request
    {
        $headers[self::TOKEN_HEADER] = $this->getToken();
        if (is_string($this->auth)) {
            $headers['Authorization'] = sprintf('Basic %s', $this->auth);
        }
        $body = ['method' => $method, 'arguments' => $arguments];

        return new Request('POST', $this->getUrl() . $this->getPath(), $headers, json_encode($body));
    }

    /**
     * @throws ClientException
     */
    protected function validateResponse(Response $response, string $method, array $arguments): \stdClass
    {
        if (!in_array($response->getStatusCode(), [200, 401, 409])) {
            throw new ClientException('Unexpected response received from Transmission', $response->getStatusCode());
        }

        if (401 == $response->getStatusCode()) {
            throw new ClientException('Access to Transmission requires authentication', 401);
        }

        if (409 == $response->getStatusCode()) {
            $this->setToken($response->getHeader(self::TOKEN_HEADER)[0]);

            return $this->call($method, $arguments);
        }

        return json_decode($response->getBody()->__toString());
    }
}
