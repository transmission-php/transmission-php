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

    /**
     * {@inheritdoc}
     */
    public static function getMapping(): array
    {
        return [
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
        ];
    }

    public function save(): void
    {
        $arguments = [];

        foreach ($this->getMapping() as $key => $value) {
            $arguments[$key] = $this->{$value};
        }

        if (!empty($arguments) && $this->getClient()) {
            ResponseValidator::validate(
                'session-set',
                $this->getClient()->call('session-set', $arguments)
            );
        }
    }
}
