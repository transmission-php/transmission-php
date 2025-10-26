<?php

namespace Transmission\Model;

class Status extends AbstractModel
{
    /**
     * @var int
     */
    const STATUS_STOPPED = 0;

    /**
     * @var int
     */
    const STATUS_CHECK_WAIT = 1;

    /**
     * @var int
     */
    const STATUS_CHECK = 2;

    /**
     * @var int
     */
    const STATUS_DOWNLOAD_WAIT = 3;

    /**
     * @var int
     */
    const STATUS_DOWNLOAD = 4;

    /**
     * @var int
     */
    const STATUS_SEED_WAIT = 5;

    /**
     * @var int
     */
    const STATUS_SEED = 6;

    /**
     * @var int
     */
    protected $status;

    /**
     * @param int|Status $status
     */
    public function __construct($status)
    {
        if ($status instanceof self) {
            $this->status = $status->getValue();
        } else {
            $this->status = (int) $status;
        }
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isStopped()
    {
        return self::STATUS_STOPPED == $this->status;
    }

    /**
     * @return bool
     */
    public function isChecking()
    {
        return self::STATUS_CHECK == $this->status ||
            self::STATUS_CHECK_WAIT == $this->status;
    }

    /**
     * @return bool
     */
    public function isDownloading()
    {
        return self::STATUS_DOWNLOAD == $this->status ||
            self::STATUS_DOWNLOAD_WAIT == $this->status;
    }

    /**
     * @return bool
     */
    public function isSeeding()
    {
        return self::STATUS_SEED == $this->status ||
            self::STATUS_SEED_WAIT == $this->status;
    }
}
