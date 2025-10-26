<?php

namespace Transmission\Model;

use Transmission\Util\ResponseValidator;

class Session extends AbstractModel
{
    /**
     * @var int
     */
    protected $altSpeedDown;

    /**
     * @var bool
     */
    protected $altSpeedEnabled;

    /**
     * @var string
     */
    protected $downloadDir;

    /**
     * @var bool
     */
    protected $downloadQueueEnabled;

    /**
     * @var int
     */
    protected $downloadQueueSize;

    /**
     * @var string
     */
    protected $incompleteDir;

    /**
     * @var bool
     */
    protected $incompleteDirEnabled;

    /**
     * @var string
     */
    protected $torrentDoneScript;

    /**
     * @var bool
     */
    protected $torrentDoneScriptEnabled;

    /**
     * @var float
     */
    protected $seedRatioLimit;

    /**
     * @var bool
     */
    protected $seedRatioLimited;

    /**
     * @var int
     */
    protected $seedQueueSize;

    /**
     * @var bool
     */
    protected $seedQueueEnabled;

    /**
     * @var int
     */
    protected $downloadSpeedLimit;

    /**
     * @var bool
     */
    protected $downloadSpeedLimitEnabled;

    /**
     * @var int
     */
    protected $uploadSpeedLimit;

    /**
     * @var bool
     */
    protected $uploadSpeedLimitEnabled;

    /**
     * @var bool
     */
    protected $sequentialDownload;

    /**
     * @var string
     */
    protected $defaultTrackers;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var int
     */
    protected $rpcVersion;

    /**
     * @var string
     */
    protected $rpcVersionSemver;

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * @var bool
     */
    protected $dhtEnabled;

    /**
     * @var bool
     */
    protected $pexEnabled;

    /**
     * @var bool
     */
    protected $lpdEnabled;

    /**
     * @var bool
     */
    protected $utpEnabled;

    /**
     * @var bool
     */
    protected $portForwardingEnabled;

    /**
     * @var int
     */
    protected $peerPort;

    /**
     * @var bool
     */
    protected $peerPortRandomOnStart;

    /**
     * @var string
     */
    protected $encryption;

    /**
     * @var bool
     */
    protected $blocklistEnabled;

    /**
     * @var int
     */
    protected $blocklistSize;

    /**
     * @var string
     */
    protected $blocklistUrl;

    public function setAltSpeedDown(int $speed)
    {
        $this->altSpeedDown = $speed;
    }

    public function getAltSpeedDown(): int
    {
        return $this->altSpeedDown;
    }

    public function setAltSpeedEnabled(bool $enabled)
    {
        $this->altSpeedEnabled = $enabled;
    }

    public function isAltSpeedEnabled(): bool
    {
        return $this->altSpeedEnabled;
    }

    public function setDownloadDir(string $downloadDir)
    {
        $this->downloadDir = $downloadDir;
    }

    public function getDownloadDir(): string
    {
        return $this->downloadDir;
    }

    public function setDownloadQueueEnabled(bool $enabled)
    {
        $this->downloadQueueEnabled = $enabled;
    }

    public function isDownloadQueueEnabled(): bool
    {
        return $this->downloadQueueEnabled;
    }

    public function setDownloadQueueSize(int $size)
    {
        $this->downloadQueueSize = $size;
    }

    public function getDownloadQueueSize(): int
    {
        return $this->downloadQueueSize;
    }

    public function setIncompleteDir(string $directory)
    {
        $this->incompleteDir = $directory;
    }

    public function getIncompleteDir(): string
    {
        return $this->incompleteDir;
    }

    public function setIncompleteDirEnabled(bool $enabled)
    {
        $this->incompleteDirEnabled = $enabled;
    }

    public function isIncompleteDirEnabled(): bool
    {
        return $this->incompleteDirEnabled;
    }

    public function setTorrentDoneScript(string $filename)
    {
        $this->torrentDoneScript = $filename;
    }

    public function getTorrentDoneScript(): string
    {
        return $this->torrentDoneScript;
    }

    public function setTorrentDoneScriptEnabled(bool $enabled)
    {
        $this->torrentDoneScriptEnabled = $enabled;
    }

    public function isTorrentDoneScriptEnabled(): bool
    {
        return $this->torrentDoneScriptEnabled;
    }

    public function setSeedRatioLimit(float $limit)
    {
        $this->seedRatioLimit = $limit;
    }

    public function getSeedRatioLimit(): float
    {
        return $this->seedRatioLimit;
    }

    public function setSeedRatioLimited(bool $limited)
    {
        $this->seedRatioLimited = $limited;
    }

    public function isSeedRatioLimited(): bool
    {
        return $this->seedRatioLimited;
    }

    public function setSeedQueueSize(int $size)
    {
        $this->seedQueueSize = $size;
    }

    public function getSeedQueueSize(): int
    {
        return $this->seedQueueSize;
    }

    public function setSeedQueueEnabled(bool $enabled)
    {
        $this->seedQueueEnabled = $enabled;
    }

    public function isSeedQueueEnabled(): bool
    {
        return $this->seedQueueEnabled;
    }

    public function setDownloadSpeedLimit(int $limit)
    {
        $this->downloadSpeedLimit = $limit;
    }

    public function getDownloadSpeedLimit(): int
    {
        return $this->downloadSpeedLimit;
    }

    public function setDownloadSpeedLimitEnabled(bool $enabled)
    {
        $this->downloadSpeedLimitEnabled = $enabled;
    }

    public function isDownloadSpeedLimitEnabled(): bool
    {
        return $this->downloadSpeedLimitEnabled;
    }

    public function setUploadSpeedLimit(int $limit)
    {
        $this->uploadSpeedLimit = $limit;
    }

    public function getUploadSpeedLimit(): int
    {
        return $this->uploadSpeedLimit;
    }

    public function setUploadSpeedLimitEnabled(bool $enabled)
    {
        $this->uploadSpeedLimitEnabled = $enabled;
    }

    public function isUploadSpeedLimitEnabled(): bool
    {
        return $this->uploadSpeedLimitEnabled;
    }

    public function getSequentialDownload(): ?bool
    {
        return $this->sequentialDownload;
    }

    public function setSequentialDownload(?bool $sequentialDownload)
    {
        $this->sequentialDownload = $sequentialDownload;
    }

    public function getDefaultTrackers(): ?string
    {
        return $this->defaultTrackers;
    }

    public function setDefaultTrackers(?string $defaultTrackers)
    {
        $this->defaultTrackers = $defaultTrackers;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version)
    {
        $this->version = $version;
    }

    public function getRpcVersion(): ?int
    {
        return $this->rpcVersion;
    }

    public function setRpcVersion(?int $rpcVersion)
    {
        $this->rpcVersion = $rpcVersion;
    }

    public function getRpcVersionSemver(): ?string
    {
        return $this->rpcVersionSemver;
    }

    public function setRpcVersionSemver(?string $rpcVersionSemver)
    {
        $this->rpcVersionSemver = $rpcVersionSemver;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getDhtEnabled(): ?bool
    {
        return $this->dhtEnabled;
    }

    public function setDhtEnabled(?bool $dhtEnabled)
    {
        $this->dhtEnabled = $dhtEnabled;
    }

    public function getPexEnabled(): ?bool
    {
        return $this->pexEnabled;
    }

    public function setPexEnabled(?bool $pexEnabled)
    {
        $this->pexEnabled = $pexEnabled;
    }

    public function getLpdEnabled(): ?bool
    {
        return $this->lpdEnabled;
    }

    public function setLpdEnabled(?bool $lpdEnabled)
    {
        $this->lpdEnabled = $lpdEnabled;
    }

    public function getUtpEnabled(): ?bool
    {
        return $this->utpEnabled;
    }

    public function setUtpEnabled(?bool $utpEnabled)
    {
        $this->utpEnabled = $utpEnabled;
    }

    public function getPortForwardingEnabled(): ?bool
    {
        return $this->portForwardingEnabled;
    }

    public function setPortForwardingEnabled(?bool $portForwardingEnabled)
    {
        $this->portForwardingEnabled = $portForwardingEnabled;
    }

    public function getPeerPort(): ?int
    {
        return $this->peerPort;
    }

    public function setPeerPort(?int $peerPort)
    {
        $this->peerPort = $peerPort;
    }

    public function getPeerPortRandomOnStart(): ?bool
    {
        return $this->peerPortRandomOnStart;
    }

    public function setPeerPortRandomOnStart(?bool $peerPortRandomOnStart)
    {
        $this->peerPortRandomOnStart = $peerPortRandomOnStart;
    }

    public function getEncryption(): ?string
    {
        return $this->encryption;
    }

    public function setEncryption(?string $encryption)
    {
        $this->encryption = $encryption;
    }

    public function getBlocklistEnabled(): ?bool
    {
        return $this->blocklistEnabled;
    }

    public function setBlocklistEnabled(?bool $blocklistEnabled)
    {
        $this->blocklistEnabled = $blocklistEnabled;
    }

    public function getBlocklistSize(): ?int
    {
        return $this->blocklistSize;
    }

    public function setBlocklistSize(?int $blocklistSize)
    {
        $this->blocklistSize = $blocklistSize;
    }

    public function getBlocklistUrl(): ?string
    {
        return $this->blocklistUrl;
    }

    public function setBlocklistUrl(?string $blocklistUrl)
    {
        $this->blocklistUrl = $blocklistUrl;
    }

    public static function getMapping(): array
    {
        return [
            // Existing fields
            'alt-speed-down'               => 'altSpeedDown',
            'alt-speed-enabled'            => 'altSpeedEnabled',
            'download-dir'                 => 'downloadDir',
            'download-queue-enabled'       => 'downloadQueueEnabled',
            'download-queue-size'          => 'downloadQueueSize',
            'incomplete-dir'               => 'incompleteDir',
            'incomplete-dir-enabled'       => 'incompleteDirEnabled',
            'script-torrent-done-filename' => 'torrentDoneScript',
            'script-torrent-done-enabled'  => 'torrentDoneScriptEnabled',
            'seedRatioLimit'               => 'seedRatioLimit',
            'seedRatioLimited'             => 'seedRatioLimited',
            'seed-queue-size'              => 'seedQueueSize',
            'seed-queue-enabled'           => 'seedQueueEnabled',
            'speed-limit-down'             => 'downloadSpeedLimit',
            'speed-limit-down-enabled'     => 'downloadSpeedLimitEnabled',
            'speed-limit-up'               => 'uploadSpeedLimit',
            'speed-limit-up-enabled'       => 'uploadSpeedLimitEnabled',

            // New RPC v17-18 fields
            'sequential_download'       => 'sequentialDownload',
            'default-trackers'          => 'defaultTrackers',
            'version'                   => 'version',
            'rpc-version'               => 'rpcVersion',
            'rpc-version-semver'        => 'rpcVersionSemver',
            'session-id'                => 'sessionId',
            'dht-enabled'               => 'dhtEnabled',
            'pex-enabled'               => 'pexEnabled',
            'lpd-enabled'               => 'lpdEnabled',
            'utp-enabled'               => 'utpEnabled',
            'port-forwarding-enabled'   => 'portForwardingEnabled',
            'peer-port'                 => 'peerPort',
            'peer-port-random-on-start' => 'peerPortRandomOnStart',
            'encryption'                => 'encryption',
            'blocklist-enabled'         => 'blocklistEnabled',
            'blocklist-size'            => 'blocklistSize',
            'blocklist-url'             => 'blocklistUrl',
        ];
    }

    public function save(): void
    {
        $arguments = [];

        foreach ($this->getMapping() as $key => $value) {
            // Only include fields that have been explicitly set (not null)
            if ($this->{$value} !== null) {
                $arguments[$key] = $this->{$value};
            }
        }

        if (!empty($arguments) && $this->getClient()) {
            ResponseValidator::validate(
                'session-set',
                $this->getClient()->call('session-set', $arguments)
            );
        }
    }
}
