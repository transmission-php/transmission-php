<?php

namespace Transmission\Model;

class Tracker extends AbstractModel
{
    protected ?int $id = null;

    protected ?int $tier = null;

    protected ?string $scrape = null;

    protected ?string $announce = null;

    protected ?string $sitename = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTier(int $tier): void
    {
        $this->tier = $tier;
    }

    public function getTier(): ?int
    {
        return $this->tier;
    }

    public function setScrape(string $scrape): void
    {
        $this->scrape = $scrape;
    }

    public function getScrape(): ?string
    {
        return $this->scrape;
    }

    public function setAnnounce(string $announce): void
    {
        $this->announce = $announce;
    }

    public function getAnnounce(): ?string
    {
        return $this->announce;
    }

    public function getSitename(): ?string
    {
        return $this->sitename;
    }

    public function setSitename(?string $sitename): void
    {
        $this->sitename = $sitename;
    }

    public static function getMapping(): array
    {
        return [
            'id'       => 'id',
            'tier'     => 'tier',
            'scrape'   => 'scrape',
            'announce' => 'announce',
            'sitename' => 'sitename',
        ];
    }
}
