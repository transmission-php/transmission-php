<?php

namespace Transmission\Model\Stats;

use Transmission\Model\AbstractModel;

class Session extends AbstractModel
{
    /**
     * @var int
     */
    private $activeTorrentCount;

    /**
     * @var int
     */
    private $downloadSpeed;

    /**
     * @var int
     */
    private $pausedTorrentCount;

    /**
     * @var int
     */
    private $torrentCount;

    /**
     * @var int
     */
    private $uploadSpeed;

    /**
     * @var Stats
     */
    private $cumulative;

    /**
     * @var Stats
     */
    private $current;

    /**
     * Gets the value of activeTorrentCount.
     */
    public function getActiveTorrentCount(): int
    {
        return $this->activeTorrentCount;
    }

    /**
     * Sets the value of activeTorrentCount.
     *
     * @param int $activeTorrentCount the active torrent count
     */
    public function setActiveTorrentCount(int $activeTorrentCount)
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

    /**
     * Sets the value of downloadSpeed.
     *
     * @param int $downloadSpeed the download speed
     */
    public function setDownloadSpeed(int $downloadSpeed)
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
    public function setPausedTorrentCount(int $pausedTorrentCount)
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

    /**
     * Sets the value of torrentCount.
     *
     * @param int $torrentCount the torrent count
     */
    public function setTorrentCount($torrentCount)
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

    /**
     * Sets the value of uploadSpeed.
     */
    public function setUploadSpeed(int $uploadSpeed)
    {
        $this->uploadSpeed = $uploadSpeed;
    }

    /**
     * Gets the value of cumulative.
     */
    public function getCumulative(): Stats
    {
        return $this->cumulative;
    }

    /**
     * Sets the value of cumulative.
     *
     * @param Stats $cumulative the cumulative
     */
    public function setCumulative(Stats $cumulative)
    {
        $this->cumulative = $cumulative;
    }

    /**
     * Gets the value of current.
     */
    public function getCurrent(): Stats
    {
        return $this->current;
    }

    /**
     * Sets the value of current.
     *
     * @param Stats $current the current
     */
    public function setCurrent(Stats $current)
    {
        $this->current = $current;
    }

    /**
     * {@inheritdoc}
     */
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
