<?php

namespace Transmission\Model\Stats;

use Transmission\Model\ModelInterface;

class Stats implements ModelInterface
{
    /**
     * @var int
     */
    protected $downloadedBytes;

    /**
     * @var int
     */
    protected $filesAdded;

    /**
     * @var int
     */
    protected $secondsActive;

    /**
     * @var int
     */
    protected $sessionCount;

    /**
     * @var int
     */
    protected $uploadedBytes;

    /**
     * Gets the value of downloadedBytes.
     *
     * @return int
     */
    public function getDownloadedBytes()
    {
        return $this->downloadedBytes;
    }

    /**
     * Sets the value of downloadedBytes.
     *
     * @param int $downloadedBytes the downloaded bytes
     */
    public function setDownloadedBytes($downloadedBytes)
    {
        $this->downloadedBytes = $downloadedBytes;
    }

    /**
     * Gets the value of filesAdded.
     *
     * @return int
     */
    public function getFilesAdded()
    {
        return $this->filesAdded;
    }

    /**
     * Sets the value of filesAdded.
     *
     * @param int $filesAdded the files added
     */
    public function setFilesAdded($filesAdded)
    {
        $this->filesAdded = $filesAdded;
    }

    /**
     * Gets the value of secondsActive.
     *
     * @return int
     */
    public function getSecondsActive()
    {
        return $this->secondsActive;
    }

    /**
     * Sets the value of secondsActive.
     *
     * @param int $secondsActive the seconds active
     */
    public function setSecondsActive($secondsActive)
    {
        $this->secondsActive = $secondsActive;
    }

    /**
     * Gets the value of sessionCount.
     *
     * @return int
     */
    public function getSessionCount()
    {
        return $this->sessionCount;
    }

    /**
     * Sets the value of sessionCount.
     *
     * @param int $sessionCount the session count
     */
    public function setSessionCount($sessionCount)
    {
        $this->sessionCount = $sessionCount;
    }

    /**
     * Gets the value of uploadedBytes.
     *
     * @return int
     */
    public function getUploadedBytes()
    {
        return $this->uploadedBytes;
    }

    /**
     * Sets the value of uploadedBytes.
     *
     * @param int $uploadedBytes the uploaded bytes
     */
    public function setUploadedBytes($uploadedBytes)
    {
        $this->uploadedBytes = $uploadedBytes;
    }

    /**
     * {@inheritdoc}
     */
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
