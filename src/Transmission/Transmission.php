<?php

namespace Transmission;

use Transmission\Model\BandwidthGroup;
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

    public function __construct(?string $host = null, ?int $port = null, ?string $path = null)
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
    public function get(string $id): Torrent
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
    public function getFreeSpace(?string $path = null): FreeSpace
    {
        if (!$path) {
            $path = $this->getSession()->getDownloadDir();
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
    public function add(string $torrent, bool $metainfo = false, ?string $savepath = null): Torrent
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
     * @throws Exception\ClientException
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

    /**
     * Add a torrent with labels support.
     */
    public function addWithLabels(string $torrent, bool $metainfo = false, ?string $savepath = null, array $labels = []): Torrent
    {
        $parameters = [$metainfo ? 'metainfo' : 'filename' => $torrent];

        if (null !== $savepath) {
            $parameters['download-dir'] = (string) $savepath;
        }

        if (!empty($labels)) {
            $parameters['labels'] = $labels;
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
     * Get torrents with support for recently-active filter and table format.
     */
    public function getTorrents($ids = null, ?array $fields = null, string $format = 'objects'): array
    {
        $arguments = [];

        if ($ids === 'recently-active') {
            $arguments['ids'] = 'recently-active';
        } elseif ($ids !== null) {
            $arguments['ids'] = is_array($ids) ? $ids : [$ids];
        }

        if ($fields !== null) {
            $arguments['fields'] = $fields;
        } else {
            $arguments['fields'] = array_keys(Torrent::getMapping());
        }

        if ($format === 'table') {
            $arguments['format'] = 'table';
        }

        $response = $this->getClient()->call('torrent-get', $arguments);
        $result   = $this->getValidator()->validate('torrent-get', $response);

        if ($format === 'table') {
            return $result; // Return raw table format
        }

        $client = $this->getClient();
        $mapper = $this->getMapper();

        $torrents = array_map(function ($data) use ($mapper, $client) {
            return $mapper->map(
                new Torrent($client),
                $data
            );
        }, $result['torrents']);

        return $torrents;
    }

    /**
     * Get recently active torrents.
     */
    public function getRecentlyActive(): array
    {
        return $this->getTorrents('recently-active');
    }

    /**
     * Move torrent to top of queue.
     */
    public function queueMoveTop($torrents): void
    {
        $ids = $this->extractIds($torrents);
        $this->getClient()->call('queue-move-top', ['ids' => $ids]);
    }

    /**
     * Move torrent up in queue.
     */
    public function queueMoveUp($torrents): void
    {
        $ids = $this->extractIds($torrents);
        $this->getClient()->call('queue-move-up', ['ids' => $ids]);
    }

    /**
     * Move torrent down in queue.
     */
    public function queueMoveDown($torrents): void
    {
        $ids = $this->extractIds($torrents);
        $this->getClient()->call('queue-move-down', ['ids' => $ids]);
    }

    /**
     * Move torrent to bottom of queue.
     */
    public function queueMoveBottom($torrents): void
    {
        $ids = $this->extractIds($torrents);
        $this->getClient()->call('queue-move-bottom', ['ids' => $ids]);
    }

    /**
     * Rename a torrent's path.
     */
    public function renamePath(Torrent $torrent, string $path, string $name): array
    {
        $response = $this->getClient()->call(
            'torrent-rename-path',
            [
                'ids'  => [$torrent->getId()],
                'path' => $path,
                'name' => $name,
            ]
        );

        return $this->getValidator()->validate('torrent-rename-path', $response);
    }

    /**
     * Update blocklist and return the new size.
     */
    public function updateBlocklist(): int
    {
        $response = $this->getClient()->call('blocklist-update', []);
        $result   = $this->getValidator()->validate('blocklist-update', $response);

        return $result['blocklist-size'];
    }

    /**
     * Test if port is open.
     */
    public function testPort(string $ipProtocol = 'ipv4'): array
    {
        $arguments = [];
        if (in_array($ipProtocol, ['ipv4', 'ipv6'])) {
            $arguments['ip_protocol'] = $ipProtocol;
        }

        $response = $this->getClient()->call('port-test', $arguments);

        return $this->getValidator()->validate('port-test', $response);
    }

    /**
     * Close the session (shutdown Transmission).
     */
    public function closeSession(): void
    {
        $this->getClient()->call('session-close', []);
    }

    /**
     * Get bandwidth groups.
     */
    public function getBandwidthGroups($groups = null): array
    {
        $arguments = [];
        if ($groups !== null) {
            $arguments['group'] = is_array($groups) ? $groups : [$groups];
        }

        $response = $this->getClient()->call('group-get', $arguments);
        $result   = $this->getValidator()->validate('group-get', $response);

        $mapper          = $this->getMapper();
        $bandwidthGroups = array_map(function ($data) use ($mapper) {
            return $mapper->map(new BandwidthGroup($this->getClient()), $data);
        }, $result['group']);

        return $bandwidthGroups;
    }

    /**
     * Create or update a bandwidth group.
     */
    public function setBandwidthGroup(string $name, array $settings = []): void
    {
        $arguments = array_merge(['name' => $name], $settings);
        $this->getClient()->call('group-set', $arguments);
    }

    /**
     * Set torrent settings including new RPC v17+ features.
     */
    public function setTorrent($torrents, array $settings): void
    {
        $ids       = $this->extractIds($torrents);
        $arguments = array_merge(['ids' => $ids], $settings);
        $this->getClient()->call('torrent-set', $arguments);
    }

    /**
     * Extract torrent IDs from various input formats.
     */
    private function extractIds($torrents): array
    {
        if (is_array($torrents)) {
            return array_map(function ($torrent) {
                return $torrent instanceof Torrent ? $torrent->getId() : $torrent;
            }, $torrents);
        }

        return [$torrents instanceof Torrent ? $torrents->getId() : $torrents];
    }
}
