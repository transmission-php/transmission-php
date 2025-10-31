<?php

namespace Transmission\Model;

class TrackerStats extends AbstractModel
{
    protected ?string $host = null;

    protected ?int $leecherCount = null;

    protected ?int $seederCount = null;

    protected ?string $lastAnnounceResult = null;

    protected ?string $lastScrapeResult = null;

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setLastAnnounceResult(string $lastAnnounceResult): void
    {
        $this->lastAnnounceResult = $lastAnnounceResult;
    }

    public function getLastAnnounceResult(): ?string
    {
        return $this->lastAnnounceResult;
    }

    public function setLastScrapeResult(string $lastScrapeResult): void
    {
        $this->lastScrapeResult = $lastScrapeResult;
    }

    public function getLastScrapeResult(): ?string
    {
        return $this->lastScrapeResult;
    }

    public function setSeederCount(int $seederCount): void
    {
        $this->seederCount = $seederCount;
    }

    public function getSeederCount(): ?int
    {
        return $this->seederCount;
    }

    public function setLeecherCount(int $leecherCount): void
    {
        $this->leecherCount = $leecherCount;
    }

    public function getLeecherCount(): ?int
    {
        return $this->leecherCount;
    }

    public static function getMapping(): array
    {
        return [
            'host'               => 'host',
            'leecherCount'       => 'leecherCount',
            'seederCount'        => 'seederCount',
            'lastScrapeResult'   => 'lastScrapeResult',
            'lastAnnounceResult' => 'lastAnnounceResult',
        ];
    }
}
