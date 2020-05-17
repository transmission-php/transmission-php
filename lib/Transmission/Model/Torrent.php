<?php

namespace Transmission\Model;

use Transmission\Util\PropertyMapper;

class Torrent extends AbstractModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var int
     */
    protected $doneDate;

    /**
     * @var int
     */
    protected $eta;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var bool
     */
    protected $finished;

    /**
     * @var bool
     */
    protected $private;

    /**
     * @var int
     */
    protected $startDate;

    /**
     * @var int
     */
    protected $uploadRate;

    /**
     * @var int
     */
    protected $downloadRate;

    /**
     * @var int
     */
    protected $peersConnected;

    /**
     * @var float
     */
    protected $percentDone;

    /**
     * @var array
     */
    protected $files = [];

    /**
     * @var array
     */
    protected $peers = [];

    /**
     * @var array
     */
    protected $trackers = [];

    /**
     * @var array
     */
    protected $trackerStats = [];

    /**
     * @var float
     */
    protected $uploadRatio;

    /**
     * @var string
     */
    protected $downloadDir;

    /**
     * @var int
     */
    protected $downloadedEver;

    /**
     * @var int
     */
    protected $uploadedEver;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setEta(int $eta)
    {
        $this->eta = $eta;
    }

    public function getEta(): int
    {
        return $this->eta;
    }

    public function setSize(int $size)
    {
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setHash(string $hash)
    {
        $this->hash = $hash;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setStatus(int $status)
    {
        $this->status = new Status($status);
    }

    public function getStatus(): int
    {
        return $this->status->getValue();
    }

    public function setFinished(bool $finished)
    {
        $this->finished = $finished;
    }

    public function isFinished(): bool
    {
        return $this->finished || 100 == $this->getPercentDone();
    }

    public function setPrivate(bool $private)
    {
        $this->private = $private;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    public function setStartDate(int $startDate)
    {
        $this->startDate = $startDate;
    }

    public function getStartDate(): int
    {
        return $this->startDate;
    }

    public function setUploadRate(int $rate)
    {
        $this->uploadRate = $rate;
    }

    public function getUploadRate(): int
    {
        return $this->uploadRate;
    }

    public function setDownloadRate(int $rate)
    {
        $this->downloadRate = $rate;
    }

    public function setPeersConnected(int $peersConnected)
    {
        $this->peersConnected = $peersConnected;
    }

    public function getPeersConnected(): int
    {
        return $this->peersConnected;
    }

    public function getDownloadRate(): int
    {
        return $this->downloadRate;
    }

    public function setPercentDone(float $done)
    {
        $this->percentDone = $done;
    }

    public function getPercentDone(): float
    {
        return $this->percentDone * 100;
    }

    public function setFiles(array $files)
    {
        $this->files = array_map(function ($file) {
            return PropertyMapper::map(new File(), $file);
        }, $files);
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setPeers(array $peers)
    {
        $this->peers = array_map(function ($peer) {
            return PropertyMapper::map(new Peer(), $peer);
        }, $peers);
    }

    public function getPeers(): array
    {
        return $this->peers;
    }

    public function setTrackerStats(array $trackerStats)
    {
        $this->trackerStats = array_map(function ($trackerStats) {
            return PropertyMapper::map(new TrackerStats(), $trackerStats);
        }, $trackerStats);
    }

    public function getTrackerStats(): array
    {
        return $this->trackerStats;
    }

    public function setTrackers(array $trackers)
    {
        $this->trackers = array_map(function ($tracker) {
            return PropertyMapper::map(new Tracker(), $tracker);
        }, $trackers);
    }

    public function getTrackers(): array
    {
        return $this->trackers;
    }

    public function setUploadRatio(float $ratio)
    {
        $this->uploadRatio = $ratio;
    }

    public function getUploadRatio(): float
    {
        return $this->uploadRatio;
    }

    public function isStopped(): bool
    {
        return $this->status->isStopped();
    }

    public function isChecking(): bool
    {
        return $this->status->isChecking();
    }

    public function isDownloading(): bool
    {
        return $this->status->isDownloading();
    }

    public function isSeeding(): bool
    {
        return $this->status->isSeeding();
    }

    public function getDownloadDir(): string
    {
        return $this->downloadDir;
    }

    public function setDownloadDir(string $downloadDir)
    {
        $this->downloadDir = $downloadDir;
    }

    public function getDownloadedEver(): int
    {
        return $this->downloadedEver;
    }

    public function setDownloadedEver(int $downloadedEver)
    {
        $this->downloadedEver = $downloadedEver;
    }

    public function getUploadedEver(): int
    {
        return $this->uploadedEver;
    }

    public function setUploadedEver(int $uploadedEver)
    {
        $this->uploadedEver = $uploadedEver;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    public function getDoneDate(): int
    {
        return $this->doneDate;
    }

    public function setDoneDate(int $doneDate)
    {
        $this->doneDate = $doneDate;
    }
    /**
     * {@inheritdoc}
     */
    public static function getMapping(): array
    {
        return [
            'comment'        => 'comment',
            'doneDate'       => 'doneDate',
            'downloadDir'    => 'downloadDir',
            'downloadedEver' => 'downloadedEver',
            'eta'            => 'eta',
            'files'          => 'files',
            'hashString'     => 'hash',
            'id'             => 'id',
            'isFinished'     => 'finished',
            'isPrivate'      => 'private',
            'name'           => 'name',
            'peers'          => 'peers',
            'peersConnected' => 'peersConnected',
            'percentDone'    => 'percentDone',
            'rateDownload'   => 'downloadRate',
            'rateUpload'     => 'uploadRate',
            'sizeWhenDone'   => 'size',
            'startDate'      => 'startDate',
            'status'         => 'status',
            'trackers'       => 'trackers',
            'trackerStats'   => 'trackerStats',
            'uploadedEver'   => 'uploadedEver',
            'uploadRatio'    => 'uploadRatio',
        ];
    }
}
