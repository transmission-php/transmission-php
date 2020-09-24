<?php

namespace Transmission;

use Transmission\Model\FreeSpace;
use Transmission\Model\Session;
use Transmission\Model\Stats\Session as SessionStats;
use Transmission\Model\Torrent;
use Transmission\Util\PropertyMapper;
use Transmission\Util\ResponseValidator;

class Transmission
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ResponseValidator
     */
    protected $validator;

    /**
     * @var PropertyMapper
     */
    protected $mapper;

    public function __construct(string $host = null, int $port = null, string $path = null)
    {
        $this->setClient(new Client($host, $port, $path));
        $this->setMapper(new PropertyMapper());
        $this->setValidator(new ResponseValidator());
    }

    /**
     * Get all the torrents in the download queue.
     *
     * @return Torrent[]
     */
    public function all(): array
    {
        $client   = $this->getClient();
        $mapper   = $this->getMapper();
        $response = $this->getClient()->call(
            'torrent-get',
            ['fields' => array_keys(Torrent::getMapping())]
        );

        $torrents = array_map(function ($data) use ($mapper, $client) {
            return $mapper->map(
                new Torrent($client),
                $data
            );
        }, $this->getValidator()->validate('torrent-get', $response));

        return $torrents;
    }

    /**
     * Get a specific torrent from the download queue.
     *
     * @throws \RuntimeException
     */
    public function get(int $id): Torrent
    {
        $client   = $this->getClient();
        $mapper   = $this->getMapper();
        $response = $this->getClient()->call('torrent-get', [
            'fields' => array_keys(Torrent::getMapping()),
            'ids'    => [$id],
        ]);

        $torrent = array_reduce(
            $this->getValidator()->validate('torrent-get', $response),
            function ($torrent, $data) use ($mapper, $client) {
                return $torrent ? $torrent : $mapper->map(new Torrent($client), $data);
            }
        );

        if (!$torrent instanceof Torrent) {
            throw new \RuntimeException(sprintf('Torrent with ID %s not found', $id));
        }

        return $torrent;
    }

    /**
     * Get the Transmission session.
     */
    public function getSession(): Session
    {
        $response = $this->getClient()->call('session-get', []);

        return $this->getMapper()->map(
            new Session($this->getClient()),
            $this->getValidator()->validate('session-get', $response)
        );
    }

    public function getSessionStats(): SessionStats
    {
        $response = $this->getClient()->call('session-stats', []);

        return $this->getMapper()->map(
            new SessionStats(),
            $this->getValidator()->validate('session-stats', $response)
        );
    }

    /**
     * Get Free space.
     */
    public function getFreeSpace(string $path = null): FreeSpace
    {
        if (!$path) {
            $path = $this->getSession()->getDownloadDir();
            var_dump($path);
        }
        $response = $this->getClient()->call(
            'free-space',
            ['path' => $path]
        );

        return $this->getMapper()->map(
            new FreeSpace(),
            $this->getValidator()->validate('free-space', $response)
        );
    }

    /**
     * Add a torrent to the download queue.
     */
    public function add(string $torrent, bool $metainfo = false, string $savepath = null): Torrent
    {
        $parameters = [$metainfo ? 'metainfo' : 'filename' => $torrent];

        if (null !== $savepath) {
            $parameters['download-dir'] = (string) $savepath;
        }

        $response = $this->getClient()->call(
            'torrent-add',
            $parameters
        );

        return $this->getMapper()->map(
            new Torrent($this->getClient()),
            $this->getValidator()->validate('torrent-add', $response)
        );
    }

    /**
     * Start the download of a torrent.
     */
    public function start(Torrent $torrent, bool $now = false): void
    {
        $this->getClient()->call(
            $now ? 'torrent-start-now' : 'torrent-start',
            ['ids' => [$torrent->getId()]]
        );
    }

    /**
     * Stop the download of a torrent.
     */
    public function stop(Torrent $torrent): void
    {
        $this->getClient()->call(
            'torrent-stop',
            ['ids' => [$torrent->getId()]]
        );
    }

    /**
     * Verify the download of a torrent.
     */
    public function verify(Torrent $torrent): void
    {
        $this->getClient()->call(
            'torrent-verify',
            ['ids' => [$torrent->getId()]]
        );
    }

    /**
     * Request a reannounce of a torrent.
     */
    public function reannounce(Torrent $torrent): void
    {
        $this->getClient()->call(
            'torrent-reannounce',
            ['ids' => [$torrent->getId()]]
        );
    }

    /**
     * Remove a torrent from the download queue.
     */
    public function remove(Torrent $torrent, bool $localData = false): void
    {
        $arguments = ['ids' => [$torrent->getId()]];

        if ($localData) {
            $arguments['delete-local-data'] = true;
        }

        $this->getClient()->call('torrent-remove', $arguments);
    }

    /**
     * Checks whether or not Transmission is listening on configured port/host.
     *
     * @throws \Buzz\Exception\NetworkException
     */
    public function isAvailable(): bool
    {
        $this->getClient()->call('', []);

        return true;
    }

    /**
     * Set the client used to connect to Transmission.
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * Get the client used to connect to Transmission.
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Set the hostname of the Transmission server.
     */
    public function setHost(string $host): void
    {
        $this->getClient()->setHost($host);
    }

    /**
     * Get the hostname of the Transmission server.
     */
    public function getHost(): string
    {
        return $this->getClient()->getHost();
    }

    /**
     * Set the port the Transmission server is listening on.
     */
    public function setPort(int $port): void
    {
        $this->getClient()->setPort($port);
    }

    /**
     * Get the port the Transmission server is listening on.
     */
    public function getPort(): int
    {
        return $this->getClient()->getPort();
    }

    /**
     * Set the mapper used to map responses from Transmission to models.
     */
    public function setMapper(PropertyMapper $mapper): void
    {
        $this->mapper = $mapper;
    }

    /**
     * Get the mapper used to map responses from Transmission to models.
     */
    public function getMapper(): PropertyMapper
    {
        return $this->mapper;
    }

    /**
     * Set the validator used to validate Transmission responses.
     */
    public function setValidator(ResponseValidator $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * Get the validator used to validate Transmission responses.
     */
    public function getValidator(): ResponseValidator
    {
        return $this->validator;
    }

    /**
     * Move the Torrent.
     *
     * @param Torrent $torrent  torrent object
     * @param string  $location the new torrent location
     * @param bool    $move     if true, move from previous location. otherwise, search "location" for files
     */
    public function setLocation(Torrent $torrent, string $location, bool $move = false): void
    {
        $this->getClient()->call(
            'torrent-set-location',
            [
                'ids'      => [$torrent->getId()],
                'location' => $location,
                'move'     => $move,
            ]
        );
    }
}
