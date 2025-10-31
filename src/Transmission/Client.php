<?php

namespace Transmission;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Transmission\Exception\ClientException;

/**
 * The Client class is used to make API calls to the Transmission server.
 */
class Client
{
    public const string DEFAULT_SCHEME = 'http';

    public const string DEFAULT_HOST = 'localhost';

    public const int DEFAULT_PORT = 9091;

    public const string DEFAULT_PATH = '/transmission/rpc';

    public const string TOKEN_HEADER = 'X-Transmission-Session-Id';

    protected string $scheme = self::DEFAULT_SCHEME;

    protected string $host = self::DEFAULT_HOST;

    protected int $port = self::DEFAULT_PORT;

    protected string $path = self::DEFAULT_PATH;

    protected string $token = '';

    protected HttpClientInterface $client;

    protected ?string $auth = null;

    protected ?string $username = null;

    protected ?string $password = null;

    public function __construct(?string $host = null, ?int $port = null, ?string $path = null, ?string $scheme = null)
    {
        $this->client = HttpClient::create();

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
        $this->username = $username;
        $this->password = $password;
        $this->auth     = base64_encode($username . ':' . $password);
    }

    /**
     * Make an API call.
     *
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function call(string $method, array $arguments): \stdClass
    {
        $url     = $this->buildUrl();
        $headers = $this->buildHeaders();
        $body    = $this->buildRequestBody($method, $arguments);

        try {
            $response = $this->client->request('POST', $url, [
                'headers'    => $headers,
                'body'       => $body,
                'auth_basic' => $this->username && $this->password ? [$this->username, $this->password] : null,
            ]);

            $statusCode = $response->getStatusCode();

            // Handle CSRF token requirement (409 Conflict) - check before getting content
            if (409 === $statusCode) {
                $headers         = $response->getHeaders(false);
                $sessionIdHeader = $headers['x-transmission-session-id'] ?? null;
                if ($sessionIdHeader) {
                    $this->token = $sessionIdHeader[0];

                    return $this->call($method, $arguments);
                }
            }

            $content = $response->getContent();

            return json_decode($content);
        } catch (TransportExceptionInterface $e) {
            throw new ClientException('Network error: ' . $e->getMessage(), 0, $e);
        } catch (ClientExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();

            // Handle CSRF token requirement (409 Conflict) for client exceptions
            if (409 === $statusCode) {
                $headers         = $e->getResponse()->getHeaders(false);
                $sessionIdHeader = $headers['x-transmission-session-id'] ?? null;
                if ($sessionIdHeader) {
                    $this->token = $sessionIdHeader[0];

                    return $this->call($method, $arguments);
                }
            }

            $content = $e->getResponse()->getContent(false);
            throw new ClientException(sprintf('HTTP %d: %s', $statusCode, $content), $statusCode, $e);
        } catch (ServerExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $content    = $e->getResponse()->getContent(false);
            throw new ClientException(sprintf('HTTP %d: %s', $statusCode, $content), $statusCode, $e);
        }
    }

    /**
     * Build the full URL for the Transmission RPC endpoint.
     */
    private function buildUrl(): string
    {
        return sprintf(
            '%s://%s:%d%s',
            $this->getScheme(),
            $this->getHost(),
            $this->getPort(),
            $this->getPath()
        );
    }

    /**
     * Build headers for the HTTP request.
     */
    private function buildHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'User-Agent'   => 'transmission-php/3.0',
        ];

        if ($this->token) {
            $headers[self::TOKEN_HEADER] = $this->token;
        }

        return $headers;
    }

    /**
     * Build the JSON request body.
     */
    private function buildRequestBody(string $method, array $arguments): string
    {
        $data = [
            'method'    => $method,
            'arguments' => $arguments,
        ];

        return json_encode($data);
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
     * Set the HTTP client used to connect to Transmission.
     */
    public function setClient(HttpClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * Get the underlying HTTP client.
     */
    public function getClient(): HttpClientInterface
    {
        return $this->client;
    }
}
