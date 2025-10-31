<?php

namespace Transmission\Model;

class BandwidthGroup extends AbstractModel
{
    protected ?string $name = null;

    protected ?bool $honorsSessionLimits = null;

    protected ?bool $speedLimitDownEnabled = null;

    protected ?int $speedLimitDown = null;

    protected ?bool $speedLimitUpEnabled = null;

    protected ?int $speedLimitUp = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getHonorsSessionLimits(): ?bool
    {
        return $this->honorsSessionLimits;
    }

    public function setHonorsSessionLimits(?bool $honorsSessionLimits): void
    {
        $this->honorsSessionLimits = $honorsSessionLimits;
    }

    public function getSpeedLimitDownEnabled(): ?bool
    {
        return $this->speedLimitDownEnabled;
    }

    public function setSpeedLimitDownEnabled(?bool $speedLimitDownEnabled): void
    {
        $this->speedLimitDownEnabled = $speedLimitDownEnabled;
    }

    public function getSpeedLimitDown(): ?int
    {
        return $this->speedLimitDown;
    }

    public function setSpeedLimitDown(?int $speedLimitDown): void
    {
        $this->speedLimitDown = $speedLimitDown;
    }

    public function getSpeedLimitUpEnabled(): ?bool
    {
        return $this->speedLimitUpEnabled;
    }

    public function setSpeedLimitUpEnabled(?bool $speedLimitUpEnabled): void
    {
        $this->speedLimitUpEnabled = $speedLimitUpEnabled;
    }

    public function getSpeedLimitUp(): ?int
    {
        return $this->speedLimitUp;
    }

    public function setSpeedLimitUp(?int $speedLimitUp): void
    {
        $this->speedLimitUp = $speedLimitUp;
    }

    /**
     * Save the bandwidth group settings to the server.
     */
    public function save(): void
    {
        $this->call('group-set', $this->toArray());
    }

    /**
     * Convert the bandwidth group to an array for API calls.
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->name !== null) {
            $data['name'] = $this->name;
        }
        if ($this->honorsSessionLimits !== null) {
            $data['honorsSessionLimits'] = $this->honorsSessionLimits;
        }
        if ($this->speedLimitDownEnabled !== null) {
            $data['speed-limit-down-enabled'] = $this->speedLimitDownEnabled;
        }
        if ($this->speedLimitDown !== null) {
            $data['speed-limit-down'] = $this->speedLimitDown;
        }
        if ($this->speedLimitUpEnabled !== null) {
            $data['speed-limit-up-enabled'] = $this->speedLimitUpEnabled;
        }
        if ($this->speedLimitUp !== null) {
            $data['speed-limit-up'] = $this->speedLimitUp;
        }

        return $data;
    }

    public static function getMapping(): array
    {
        return [
            'name'                     => 'name',
            'honorsSessionLimits'      => 'honorsSessionLimits',
            'speed-limit-down-enabled' => 'speedLimitDownEnabled',
            'speed-limit-down'         => 'speedLimitDown',
            'speed-limit-up-enabled'   => 'speedLimitUpEnabled',
            'speed-limit-up'           => 'speedLimitUp',
        ];
    }
}
