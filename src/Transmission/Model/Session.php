<?php

namespace Transmission\Model;

use Transmission\Util\ResponseValidator;

class Session extends AbstractModel
{
    protected ?int $altSpeedDown = null;

    protected ?bool $altSpeedEnabled = null;

    protected ?string $downloadDir = null;

    protected ?bool $downloadQueueEnabled = null;

    protected ?int $downloadQueueSize = null;

    protected ?string $incompleteDir = null;

    protected ?bool $incompleteDirEnabled = null;

    protected ?string $torrentDoneScript = null;

    protected ?bool $torrentDoneScriptEnabled = null;

    protected ?float $seedRatioLimit = null;

    protected ?bool $seedRatioLimited = null;

    protected ?int $seedQueueSize = null;

    protected ?bool $seedQueueEnabled = null;

    protected ?int $downloadSpeedLimit = null;

    protected ?bool $downloadSpeedLimitEnabled = null;

    protected ?int $uploadSpeedLimit = null;

    protected ?bool $uploadSpeedLimitEnabled = null;

    protected ?bool $sequentialDownload = null;

    protected ?string $defaultTrackers = null;

    protected ?string $version = null;

    protected ?int $rpcVersion = null;

    protected ?string $rpcVersionSemver = null;

    protected ?string $sessionId = null;

    protected ?bool $dhtEnabled = null;

    protected ?bool $pexEnabled = null;

    protected ?bool $lpdEnabled = null;

    protected ?bool $utpEnabled = null;

    protected ?bool $portForwardingEnabled = null;

    protected ?int $peerPort = null;

    protected ?bool $peerPortRandomOnStart = null;

    protected ?string $encryption = null;

    protected ?bool $blocklistEnabled = null;

    protected ?int $blocklistSize = null;

    protected ?string $blocklistUrl = null;

    public function setAltSpeedDown(int $speed): void
    {
        $this->altSpeedDown = $speed;
    }

    public function getAltSpeedDown(): int
    {
        return $this->altSpeedDown;
    }

    public function setAltSpeedEnabled(bool $enabled): void
    {
        $this->altSpeedEnabled = $enabled;
    }

    public function isAltSpeedEnabled(): bool
    {
        return $this->altSpeedEnabled;
    }

    public function setDownloadDir(string $downloadDir): void
    {
        $this->downloadDir = $downloadDir;
    }

    public function getDownloadDir(): string
    {
        return $this->downloadDir;
    }

    public function setDownloadQueueEnabled(bool $enabled): void
    {
        $this->downloadQueueEnabled = $enabled;
    }

    public function isDownloadQueueEnabled(): bool
    {
        return $this->downloadQueueEnabled;
    }

    public function setDownloadQueueSize(int $size): void
    {
        $this->downloadQueueSize = $size;
    }

    public function getDownloadQueueSize(): int
    {
        return $this->downloadQueueSize;
    }

    public function setIncompleteDir(string $directory): void
    {
        $this->incompleteDir = $directory;
    }

    public function getIncompleteDir(): string
    {
        return $this->incompleteDir;
    }

    public function setIncompleteDirEnabled(bool $enabled): void
    {
        $this->incompleteDirEnabled = $enabled;
    }

    public function isIncompleteDirEnabled(): bool
    {
        return $this->incompleteDirEnabled;
    }

    public function setTorrentDoneScript(string $filename): void
    {
        $this->torrentDoneScript = $filename;
    }

    public function getTorrentDoneScript(): string
    {
        return $this->torrentDoneScript;
    }

    public function setTorrentDoneScriptEnabled(bool $enabled): void
    {
        $this->torrentDoneScriptEnabled = $enabled;
    }

    public function isTorrentDoneScriptEnabled(): bool
    {
        return $this->torrentDoneScriptEnabled;
    }

    public function setSeedRatioLimit(float $limit): void
    {
        $this->seedRatioLimit = $limit;
    }

    public function getSeedRatioLimit(): float
    {
        return $this->seedRatioLimit;
    }

    public function setSeedRatioLimited(bool $limited): void
    {
        $this->seedRatioLimited = $limited;
    }

    public function isSeedRatioLimited(): bool
    {
        return $this->seedRatioLimited;
    }

    public function setSeedQueueSize(int $size): void
    {
        $this->seedQueueSize = $size;
    }

    public function getSeedQueueSize(): int
    {
        return $this->seedQueueSize;
    }

    public function setSeedQueueEnabled(bool $enabled): void
    {
        $this->seedQueueEnabled = $enabled;
    }

    public function isSeedQueueEnabled(): bool
    {
        return $this->seedQueueEnabled;
    }

    public function setDownloadSpeedLimit(int $limit): void
    {
        $this->downloadSpeedLimit = $limit;
    }

    public function getDownloadSpeedLimit(): int
    {
        return $this->downloadSpeedLimit;
    }

    public function setDownloadSpeedLimitEnabled(bool $enabled): void
    {
        $this->downloadSpeedLimitEnabled = $enabled;
    }

    public function isDownloadSpeedLimitEnabled(): bool
    {
        return $this->downloadSpeedLimitEnabled;
    }

    public function setUploadSpeedLimit(int $limit): void
    {
        $this->uploadSpeedLimit = $limit;
    }

    public function getUploadSpeedLimit(): int
    {
        return $this->uploadSpeedLimit;
    }

    public function setUploadSpeedLimitEnabled(bool $enabled): void
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

    public function setSequentialDownload(?bool $sequentialDownload): void
    {
        $this->sequentialDownload = $sequentialDownload;
    }

    public function getDefaultTrackers(): ?string
    {
        return $this->defaultTrackers;
    }

    public function setDefaultTrackers(?string $defaultTrackers): void
    {
        $this->defaultTrackers = $defaultTrackers;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }

    public function getRpcVersion(): ?int
    {
        return $this->rpcVersion;
    }

    public function setRpcVersion(?int $rpcVersion): void
    {
        $this->rpcVersion = $rpcVersion;
    }

    public function getRpcVersionSemver(): ?string
    {
        return $this->rpcVersionSemver;
    }

    public function setRpcVersionSemver(?string $rpcVersionSemver): void
    {
        $this->rpcVersionSemver = $rpcVersionSemver;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): void
    {
        $this->sessionId = $sessionId;
    }

    public function getDhtEnabled(): ?bool
    {
        return $this->dhtEnabled;
    }

    public function setDhtEnabled(?bool $dhtEnabled): void
    {
        $this->dhtEnabled = $dhtEnabled;
    }

    public function getPexEnabled(): ?bool
    {
        return $this->pexEnabled;
    }

    public function setPexEnabled(?bool $pexEnabled): void
    {
        $this->pexEnabled = $pexEnabled;
    }

    public function getLpdEnabled(): ?bool
    {
        return $this->lpdEnabled;
    }

    public function setLpdEnabled(?bool $lpdEnabled): void
    {
        $this->lpdEnabled = $lpdEnabled;
    }

    public function getUtpEnabled(): ?bool
    {
        return $this->utpEnabled;
    }

    public function setUtpEnabled(?bool $utpEnabled): void
    {
        $this->utpEnabled = $utpEnabled;
    }

    public function getPortForwardingEnabled(): ?bool
    {
        return $this->portForwardingEnabled;
    }

    public function setPortForwardingEnabled(?bool $portForwardingEnabled): void
    {
        $this->portForwardingEnabled = $portForwardingEnabled;
    }

    public function getPeerPort(): ?int
    {
        return $this->peerPort;
    }

    public function setPeerPort(?int $peerPort): void
    {
        $this->peerPort = $peerPort;
    }

    public function getPeerPortRandomOnStart(): ?bool
    {
        return $this->peerPortRandomOnStart;
    }

    public function setPeerPortRandomOnStart(?bool $peerPortRandomOnStart): void
    {
        $this->peerPortRandomOnStart = $peerPortRandomOnStart;
    }

    public function getEncryption(): ?string
    {
        return $this->encryption;
    }

    public function setEncryption(?string $encryption): void
    {
        $this->encryption = $encryption;
    }

    public function getBlocklistEnabled(): ?bool
    {
        return $this->blocklistEnabled;
    }

    public function setBlocklistEnabled(?bool $blocklistEnabled): void
    {
        $this->blocklistEnabled = $blocklistEnabled;
    }

    public function getBlocklistSize(): ?int
    {
        return $this->blocklistSize;
    }

    public function setBlocklistSize(?int $blocklistSize): void
    {
        $this->blocklistSize = $blocklistSize;
    }

    public function getBlocklistUrl(): ?string
    {
        return $this->blocklistUrl;
    }

    public function setBlocklistUrl(?string $blocklistUrl): void
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
