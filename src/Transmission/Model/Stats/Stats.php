<?php

namespace Transmission\Model\Stats;

use Transmission\Model\ModelInterface;

class Stats implements ModelInterface
{
    protected ?int $downloadedBytes = null;

    protected ?int $filesAdded = null;

    protected ?int $secondsActive = null;

    protected ?int $sessionCount = null;

    protected ?int $uploadedBytes = null;

    public function getDownloadedBytes(): ?int
    {
        return $this->downloadedBytes;
    }

    public function setDownloadedBytes(int $downloadedBytes): void
    {
        $this->downloadedBytes = $downloadedBytes;
    }

    public function getFilesAdded(): ?int
    {
        return $this->filesAdded;
    }

    public function setFilesAdded(int $filesAdded): void
    {
        $this->filesAdded = $filesAdded;
    }

    public function getSecondsActive(): ?int
    {
        return $this->secondsActive;
    }

    public function setSecondsActive(int $secondsActive): void
    {
        $this->secondsActive = $secondsActive;
    }

    public function getSessionCount(): ?int
    {
        return $this->sessionCount;
    }

    public function setSessionCount(int $sessionCount): void
    {
        $this->sessionCount = $sessionCount;
    }

    public function getUploadedBytes(): ?int
    {
        return $this->uploadedBytes;
    }

    public function setUploadedBytes(int $uploadedBytes): void
    {
        $this->uploadedBytes = $uploadedBytes;
    }

    public static function getMapping(): array
    {
        return [
            'downloadedBytes' => 'downloadedBytes',
            'filesAdded'      => 'filesAdded',
            'secondsActive'   => 'secondsActive',
            'sessionCount'    => 'sessionCount',
            'uploadedBytes'   => 'uploadedBytes',
        ];
    }
}
