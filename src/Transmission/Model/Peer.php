<?php

namespace Transmission\Model;

class Peer extends AbstractModel
{
    protected ?string $address = null;

    protected ?int $port = null;

    protected ?string $clientName = null;

    protected ?bool $clientChoked = null;

    protected ?bool $clientInterested = null;

    protected ?bool $downloading = null;

    protected ?bool $encrypted = null;

    protected ?bool $incoming = null;

    protected ?bool $uploading = null;

    protected ?bool $utp = null;

    protected ?bool $peerChoked = null;

    protected ?bool $peerInterested = null;

    protected ?float $progress = null;

    protected ?int $uploadRate = null;

    protected ?int $downloadRate = null;

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientChoked(bool $choked): void
    {
        $this->clientChoked = $choked;
    }

    public function isClientChoked(): ?bool
    {
        return $this->clientChoked;
    }

    public function setClientInterested(bool $interested): void
    {
        $this->clientInterested = $interested;
    }

    public function isClientInterested(): bool
    {
        return $this->clientInterested;
    }

    public function setDownloading(bool $downloading): void
    {
        $this->downloading = $downloading;
    }

    public function isDownloading(): bool
    {
        return $this->downloading;
    }

    public function setEncrypted(bool $encrypted): void
    {
        $this->encrypted = $encrypted;
    }

    public function isEncrypted(): bool
    {
        return $this->encrypted;
    }

    public function setIncoming(bool $incoming): void
    {
        $this->incoming = $incoming;
    }

    public function isIncoming(): bool
    {
        return $this->incoming;
    }

    public function setUploading(bool $uploading): void
    {
        $this->uploading = $uploading;
    }

    public function isUploading(): bool
    {
        return $this->uploading;
    }

    public function setUtp(bool $utp): void
    {
        $this->utp = $utp;
    }

    public function isUtp(): bool
    {
        return $this->utp;
    }

    public function setPeerChoked(bool $choked): void
    {
        $this->peerChoked = $choked;
    }

    public function isPeerChoked(): bool
    {
        return $this->peerChoked;
    }

    public function setPeerInterested(bool $interested): void
    {
        $this->peerInterested = $interested;
    }

    public function isPeerInterested(): bool
    {
        return $this->peerInterested;
    }

    public function setProgress(float $progress): void
    {
        $this->progress = $progress;
    }

    public function getProgress(): float
    {
        return $this->progress;
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
        $this->downloadRate = (int) $rate;
    }

    public function getDownloadRate(): int
    {
        return $this->downloadRate;
    }

    public static function getMapping(): array
    {
        return [
            'address'            => 'address',
            'port'               => 'port',
            'clientName'         => 'clientName',
            'clientIsChoked'     => 'clientChoked',
            'clientIsInterested' => 'clientInterested',
            'isDownloadingFrom'  => 'downloading',
            'isEncrypted'        => 'encrypted',
            'isIncoming'         => 'incoming',
            'isUploadingTo'      => 'uploading',
            'isUTP'              => 'utp',
            'peerIsChoked'       => 'peerChoked',
            'peerIsInterested'   => 'peerInterested',
            'progress'           => 'progress',
            'rateToClient'       => 'uploadRate',
            'rateFromClient'     => 'downloadRate',
        ];
    }
}
