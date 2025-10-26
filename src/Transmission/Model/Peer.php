<?php

namespace Transmission\Model;

class Peer extends AbstractModel
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var string
     */
    protected $clientName;

    /**
     * @var bool
     */
    protected $clientChoked;

    /**
     * @var bool
     */
    protected $clientInterested;

    /**
     * @var bool
     */
    protected $downloading;

    /**
     * @var bool
     */
    protected $encrypted;

    /**
     * @var bool
     */
    protected $incoming;

    /**
     * @var bool
     */
    protected $uploading;

    /**
     * @var bool
     */
    protected $utp;

    /**
     * @var bool
     */
    protected $peerChoked;

    /**
     * @var bool
     */
    protected $peerInterested;

    /**
     * @var float
     */
    protected $progress;

    /**
     * @var int
     */
    protected $uploadRate;

    /**
     * @var int
     */
    protected $downloadRate;

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = (string) $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = (int) $port;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $clientName
     */
    public function setClientName($clientName)
    {
        $this->clientName = (string) $clientName;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param bool $choked
     */
    public function setClientChoked($choked)
    {
        $this->clientChoked = (bool) $choked;
    }

    /**
     * @return bool
     */
    public function isClientChoked()
    {
        return $this->clientChoked;
    }

    /**
     * @param bool $interested
     */
    public function setClientInterested($interested)
    {
        $this->clientInterested = (bool) $interested;
    }

    /**
     * @return bool
     */
    public function isClientInterested()
    {
        return $this->clientInterested;
    }

    /**
     * @param bool $downloading
     */
    public function setDownloading($downloading)
    {
        $this->downloading = (bool) $downloading;
    }

    /**
     * @return bool
     */
    public function isDownloading()
    {
        return $this->downloading;
    }

    /**
     * @param bool $encrypted
     */
    public function setEncrypted($encrypted)
    {
        $this->encrypted = (bool) $encrypted;
    }

    /**
     * @return bool
     */
    public function isEncrypted()
    {
        return $this->encrypted;
    }

    /**
     * @param bool $incoming
     */
    public function setIncoming($incoming)
    {
        $this->incoming = (bool) $incoming;
    }

    /**
     * @return bool
     */
    public function isIncoming()
    {
        return $this->incoming;
    }

    /**
     * @param bool $uploading
     */
    public function setUploading($uploading)
    {
        $this->uploading = (bool) $uploading;
    }

    /**
     * @return bool
     */
    public function isUploading()
    {
        return $this->uploading;
    }

    /**
     * @param bool $utp
     */
    public function setUtp($utp)
    {
        $this->utp = (bool) $utp;
    }

    /**
     * @return bool
     */
    public function isUtp()
    {
        return $this->utp;
    }

    /**
     * @param bool $choked
     */
    public function setPeerChoked($choked)
    {
        $this->peerChoked = (bool) $choked;
    }

    /**
     * @return bool
     */
    public function isPeerChoked()
    {
        return $this->peerChoked;
    }

    /**
     * @param bool $interested
     */
    public function setPeerInterested($interested)
    {
        $this->peerInterested = (bool) $interested;
    }

    /**
     * @return bool
     */
    public function isPeerInterested()
    {
        return $this->peerInterested;
    }

    /**
     * @param float $progress
     */
    public function setProgress($progress)
    {
        $this->progress = (float) $progress;
    }

    /**
     * @return float
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param int $rate
     */
    public function setUploadRate($rate)
    {
        $this->uploadRate = (int) $rate;
    }

    /**
     * @return int
     */
    public function getUploadRate()
    {
        return $this->uploadRate;
    }

    /**
     * @param int $rate
     */
    public function setDownloadRate($rate)
    {
        $this->downloadRate = (int) $rate;
    }

    /**
     * @return int
     */
    public function getDownloadRate()
    {
        return $this->downloadRate;
    }

    /**
     * {@inheritdoc}
     */
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
