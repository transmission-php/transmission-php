<?php

namespace Transmission\Model;

use Transmission\Client;
use Transmission\Util\ResponseValidator;

/**
 * Base class for Transmission models.
 */
abstract class AbstractModel implements ModelInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Constructor.
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public static function getMapping(): array
    {
        return [];
    }

    protected function call(string $method, array $arguments)
    {
        if ($this->client) {
            ResponseValidator::validate(
                $method,
                $this->client->call($method, $arguments)
            );
        }
    }
}
