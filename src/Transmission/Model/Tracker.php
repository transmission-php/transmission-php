<?php

namespace Transmission\Model;

class Tracker extends AbstractModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $tier;

    /**
     * @var string
     */
    protected $scrape;

    /**
     * @var string
     */
    protected $announce;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $tier
     */
    public function setTier($tier)
    {
        $this->tier = (int) $tier;
    }

    /**
     * @return int
     */
    public function getTier()
    {
        return $this->tier;
    }

    /**
     * @param string $scrape
     */
    public function setScrape($scrape)
    {
        $this->scrape = (string) $scrape;
    }

    /**
     * @return string
     */
    public function getScrape()
    {
        return $this->scrape;
    }

    /**
     * @param string $announce
     */
    public function setAnnounce($announce)
    {
        $this->announce = (string) $announce;
    }

    /**
     * @return string
     */
    public function getAnnounce()
    {
        return $this->announce;
    }

    /**
     * {@inheritdoc}
     */
    public static function getMapping(): array
    {
        return [
            'id'       => 'id',
            'tier'     => 'tier',
            'scrape'   => 'scrape',
            'announce' => 'announce',
        ];
    }
}
