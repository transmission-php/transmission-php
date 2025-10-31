<?php

namespace Transmission\Model\Stats;

use Transmission\Model\AbstractModel;

class Session extends AbstractModel
{
    private ?int $activeTorrentCount = null;

    private ?int $downloadSpeed = null;

    private ?int $pausedTorrentCount = null;

    private ?int $torrentCount = null;

    private ?int $uploadSpeed = null;

    private ?Stats $cumulative = null;

    private ?Stats $current = null;

    /**
     * Gets the value of activeTorrentCount.
     */
    public function getActiveTorrentCount(): int
    {
        return $this->activeTorrentCount;
    }

    public function setActiveTorrentCount(int $activeTorrentCount): void
    {
        $this->activeTorrentCount = $activeTorrentCount;
    }

    /**
     * Gets the value of downloadSpeed.
     */
    public function getDownloadSpeed(): int
    {
        return $this->downloadSpeed;
    }

    public function setDownloadSpeed(int $downloadSpeed): void
    {
        $this->downloadSpeed = $downloadSpeed;
    }

    /**
     * Gets the value of pausedTorrentCount.
     */
    public function getPausedTorrentCount(): int
    {
        return $this->pausedTorrentCount;
    }

    /**
     * Sets the value of pausedTorrentCount.
     */
    public function setPausedTorrentCount(int $pausedTorrentCount): void
    {
        $this->pausedTorrentCount = $pausedTorrentCount;
    }

    /**
     * Gets the value of torrentCount.
     */
    public function getTorrentCount(): int
    {
        return $this->torrentCount;
    }

    public function setTorrentCount(int $torrentCount): void
    {
        $this->torrentCount = $torrentCount;
    }

    /**
     * Gets the value of uploadSpeed.
     */
    public function getUploadSpeed(): int
    {
        return $this->uploadSpeed;
    }

    public function setUploadSpeed(int $uploadSpeed): void
    {
        $this->uploadSpeed = $uploadSpeed;
    }

    public function getCumulative(): ?Stats
    {
        return $this->cumulative;
    }

    public function setCumulative(Stats $cumulative): void
    {
        $this->cumulative = $cumulative;
    }

    public function getCurrent(): ?Stats
    {
        return $this->current;
    }

    public function setCurrent(Stats $current): void
    {
        $this->current = $current;
    }

    public static function getMapping(): array
    {
        return [
            'activeTorrentCount' => 'activeTorrentCount',
            'downloadSpeed'      => 'downloadSpeed',
            'pausedTorrentCount' => 'pausedTorrentCount',
            'torrentCount'       => 'torrentCount',
            'uploadSpeed'        => 'uploadSpeed',
            'cumulative-stats'   => 'cumulative',
            'current-stats'      => 'current',
        ];
    }
}
