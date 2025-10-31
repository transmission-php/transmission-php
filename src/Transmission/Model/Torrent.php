<?php

namespace Transmission\Model;

use Transmission\Util\PropertyMapper;

class Torrent extends AbstractModel
{
    protected ?string $id = null;

    protected ?string $comment = null;

    protected ?int $doneDate = null;

    protected ?int $eta = null;

    protected ?int $size = null;

    protected ?string $name = null;

    protected ?string $hash = null;

    protected ?Status $status = null;

    protected ?bool $finished = null;

    protected ?bool $private = null;

    protected ?int $startDate = null;

    protected ?int $uploadRate = null;

    protected ?int $downloadRate = null;

    protected ?int $peersConnected = null;

    protected ?float $percentDone = null;

    protected array $files = [];

    protected array $peers = [];

    protected array $trackers = [];

    protected array $trackerStats = [];

    protected ?float $uploadRatio = null;

    protected ?string $downloadDir = null;

    protected ?int $downloadedEver = null;

    protected ?int $uploadedEver = null;

    protected ?array $availability = null;

    protected ?int $fileCount = null;

    protected ?string $group = null;

    protected ?array $labels = null;

    protected ?string $magnetLink = null;

    protected ?float $metadataPercentComplete = null;

    protected ?string $primaryMimeType = null;

    protected ?string $trackerList = null;

    protected ?int $queuePosition = null;

    protected ?float $percentComplete = null;

    protected ?int $etaIdle = null;

    protected ?int $editDate = null;

    protected ?int $addedDate = null;

    protected ?int $activityDate = null;

    protected ?bool $isStalled = null;

    protected ?int $error = null;

    protected ?string $errorString = null;

    protected ?bool $sequentialDownload = null;

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setEta(int $eta): void
    {
        $this->eta = $eta;
    }

    public function getEta(): ?int
    {
        return $this->eta;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setStatus(int $status): void
    {
        $this->status = new Status($status);
    }

    public function getStatus(): int
    {
        return $this->status->getValue();
    }

    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
    }

    public function isFinished(): bool
    {
        return $this->finished || 100 == $this->getPercentDone();
    }

    public function setPrivate(bool $private): void
    {
        $this->private = $private;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    public function setStartDate(int $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getStartDate(): int
    {
        return $this->startDate;
    }

    public function setUploadRate(int $rate): void
    {
        $this->uploadRate = $rate;
    }

    public function getUploadRate(): int
    {
        return $this->uploadRate;
    }

    public function setDownloadRate(int $rate): void
    {
        $this->downloadRate = $rate;
    }

    public function setPeersConnected(int $peersConnected): void
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

    public function setPercentDone(float $done): void
    {
        $this->percentDone = $done;
    }

    public function getPercentDone(): float
    {
        return $this->percentDone * 100;
    }

    public function setFiles(array $files): void
    {
        $this->files = array_map(function ($file) {
            return PropertyMapper::map(new File(), $file);
        }, $files);
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setPeers(array $peers): void
    {
        $this->peers = array_map(function ($peer) {
            return PropertyMapper::map(new Peer(), $peer);
        }, $peers);
    }

    public function getPeers(): array
    {
        return $this->peers;
    }

    public function setTrackerStats(array $trackerStats): void
    {
        $this->trackerStats = array_map(function ($trackerStats) {
            return PropertyMapper::map(new TrackerStats(), $trackerStats);
        }, $trackerStats);
    }

    public function getTrackerStats(): array
    {
        return $this->trackerStats;
    }

    public function setTrackers(array $trackers): void
    {
        $this->trackers = array_map(function ($tracker) {
            return PropertyMapper::map(new Tracker(), $tracker);
        }, $trackers);
    }

    public function getTrackers(): array
    {
        return $this->trackers;
    }

    public function setUploadRatio(float $ratio): void
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

    public function setDownloadDir(string $downloadDir): void
    {
        $this->downloadDir = $downloadDir;
    }

    public function getDownloadedEver(): int
    {
        return $this->downloadedEver;
    }

    public function setDownloadedEver(int $downloadedEver): void
    {
        $this->downloadedEver = $downloadedEver;
    }

    public function getUploadedEver(): int
    {
        return $this->uploadedEver;
    }

    public function setUploadedEver(int $uploadedEver): void
    {
        $this->uploadedEver = $uploadedEver;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getDoneDate(): int
    {
        return $this->doneDate;
    }

    public function setDoneDate(int $doneDate): void
    {
        $this->doneDate = $doneDate;
    }

    public function getAvailability(): ?array
    {
        return $this->availability;
    }

    public function setAvailability(?array $availability): void
    {
        $this->availability = $availability;
    }

    public function getFileCount(): ?int
    {
        return $this->fileCount;
    }

    public function setFileCount(?int $fileCount): void
    {
        $this->fileCount = $fileCount;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function setGroup(?string $group): void
    {
        $this->group = $group;
    }

    public function getLabels(): ?array
    {
        return $this->labels;
    }

    public function setLabels(?array $labels): void
    {
        $this->labels = $labels;
    }

    public function getMagnetLink(): ?string
    {
        return $this->magnetLink;
    }

    public function setMagnetLink(?string $magnetLink): void
    {
        $this->magnetLink = $magnetLink;
    }

    public function getMetadataPercentComplete(): ?float
    {
        return $this->metadataPercentComplete;
    }

    public function setMetadataPercentComplete(?float $metadataPercentComplete): void
    {
        $this->metadataPercentComplete = $metadataPercentComplete;
    }

    public function getPrimaryMimeType(): ?string
    {
        return $this->primaryMimeType;
    }

    public function setPrimaryMimeType(?string $primaryMimeType): void
    {
        $this->primaryMimeType = $primaryMimeType;
    }

    public function getTrackerList(): ?string
    {
        return $this->trackerList;
    }

    public function setTrackerList(?string $trackerList): void
    {
        $this->trackerList = $trackerList;
    }

    public function getQueuePosition(): ?int
    {
        return $this->queuePosition;
    }

    public function setQueuePosition(?int $queuePosition): void
    {
        $this->queuePosition = $queuePosition;
    }

    public function getPercentComplete(): ?float
    {
        return $this->percentComplete;
    }

    public function setPercentComplete(?float $percentComplete): void
    {
        $this->percentComplete = $percentComplete;
    }

    public function getEtaIdle(): ?int
    {
        return $this->etaIdle;
    }

    public function setEtaIdle(?int $etaIdle): void
    {
        $this->etaIdle = $etaIdle;
    }

    public function getEditDate(): ?int
    {
        return $this->editDate;
    }

    public function setEditDate(?int $editDate): void
    {
        $this->editDate = $editDate;
    }

    public function getAddedDate(): ?int
    {
        return $this->addedDate;
    }

    public function setAddedDate(?int $addedDate): void
    {
        $this->addedDate = $addedDate;
    }

    public function getActivityDate(): ?int
    {
        return $this->activityDate;
    }

    public function setActivityDate(?int $activityDate): void
    {
        $this->activityDate = $activityDate;
    }

    public function isStalled(): ?bool
    {
        return $this->isStalled;
    }

    public function setIsStalled(?bool $isStalled): void
    {
        $this->isStalled = $isStalled;
    }

    public function getError(): ?int
    {
        return $this->error;
    }

    public function setError(?int $error): void
    {
        $this->error = $error;
    }

    public function getErrorString(): ?string
    {
        return $this->errorString;
    }

    public function setErrorString(?string $errorString): void
    {
        $this->errorString = $errorString;
    }

    public function getSequentialDownload(): ?bool
    {
        return $this->sequentialDownload;
    }

    public function setSequentialDownload(?bool $sequentialDownload): void
    {
        $this->sequentialDownload = $sequentialDownload;
    }

    public static function getMapping(): array
    {
        return [
            'activityDate'            => 'activityDate',
            'addedDate'               => 'addedDate',
            'availability'            => 'availability',
            'comment'                 => 'comment',
            'doneDate'                => 'doneDate',
            'downloadDir'             => 'downloadDir',
            'downloadedEver'          => 'downloadedEver',
            'editDate'                => 'editDate',
            'error'                   => 'error',
            'errorString'             => 'errorString',
            'eta'                     => 'eta',
            'etaIdle'                 => 'etaIdle',
            'file-count'              => 'fileCount',
            'files'                   => 'files',
            'group'                   => 'group',
            'hashString'              => 'hash',
            'id'                      => 'id',
            'isFinished'              => 'finished',
            'isPrivate'               => 'private',
            'isStalled'               => 'isStalled',
            'labels'                  => 'labels',
            'magnetLink'              => 'magnetLink',
            'metadataPercentComplete' => 'metadataPercentComplete',
            'name'                    => 'name',
            'peers'                   => 'peers',
            'peersConnected'          => 'peersConnected',
            'percentComplete'         => 'percentComplete',
            'percentDone'             => 'percentDone',
            'primary-mime-type'       => 'primaryMimeType',
            'queuePosition'           => 'queuePosition',
            'rateDownload'            => 'downloadRate',
            'rateUpload'              => 'uploadRate',
            'sequential_download'     => 'sequentialDownload',
            'sizeWhenDone'            => 'size',
            'startDate'               => 'startDate',
            'status'                  => 'status',
            'trackerList'             => 'trackerList',
            'trackers'                => 'trackers',
            'trackerStats'            => 'trackerStats',
            'uploadedEver'            => 'uploadedEver',
            'uploadRatio'             => 'uploadRatio',
        ];
    }
}
