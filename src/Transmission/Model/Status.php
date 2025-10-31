<?php

namespace Transmission\Model;

class Status extends AbstractModel
{
    public const int STATUS_STOPPED = 0;

    public const int STATUS_CHECK_WAIT = 1;

    public const int STATUS_CHECK = 2;

    public const int STATUS_DOWNLOAD_WAIT = 3;

    public const int STATUS_DOWNLOAD = 4;

    public const int STATUS_SEED_WAIT = 5;

    public const int STATUS_SEED = 6;

    protected int $status;

    public function __construct(int|Status $status)
    {
        if ($status instanceof self) {
            $this->status = $status->getValue();
        } else {
            $this->status = $status;
        }
    }

    public function getValue(): int
    {
        return $this->status;
    }

    public function isStopped(): bool
    {
        return self::STATUS_STOPPED == $this->status;
    }

    public function isChecking(): bool
    {
        return self::STATUS_CHECK      == $this->status
            || self::STATUS_CHECK_WAIT == $this->status;
    }

    public function isDownloading(): bool
    {
        return self::STATUS_DOWNLOAD      == $this->status
            || self::STATUS_DOWNLOAD_WAIT == $this->status;
    }

    public function isSeeding(): bool
    {
        return self::STATUS_SEED      == $this->status
            || self::STATUS_SEED_WAIT == $this->status;
    }
}
