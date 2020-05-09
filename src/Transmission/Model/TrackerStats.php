<?php

namespace Transmission\Model;

class TrackerStats extends AbstractModel
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $leecherCount;

    /**
     * @var int
     */
    protected $seederCount;

    /**
     * @var string
     */
    protected $lastAnnounceResult;

    /**
     * @var string
     */
    protected $lastScrapeResult;

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host =  (string) $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $lastAnnounceResult
     */
    public function setLastAnnounceResult($lastAnnounceResult)
    {
        $this->lastAnnounceResult =  (string) $lastAnnounceResult;
    }

    /**
     * @return string
     */
    public function getLastAnnounceResult()
    {
        return $this->lastAnnounceResult;
    }

    /**
     * @param string $lastScrapeResult
     */
    public function setLastScrapeResult($lastScrapeResult)
    {
        $this->lastScrapeResult =  (string) $lastScrapeResult;
    }

    /**
     * @return string
     */
    public function getLastScrapeResult()
    {
        return $this->lastScrapeResult;
    }

    /**
     * @param int $seederCount
     */
    public function setSeederCount($seederCount)
    {
        $this->seederCount = (int) $seederCount;
    }

    /**
     * @return int
     */
    public function getSeederCount()
    {
        return $this->seederCount;
    }

    /**
     * @param int $leecherCount
     */
    public function setLeecherCount($leecherCount)
    {
        $this->leecherCount = (int) $leecherCount;
    }

    /**
     * @return int
     */
    public function getLeecherCount()
    {
        return $this->leecherCount;
    }

    /**
     * {@inheritdoc}
     */
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
