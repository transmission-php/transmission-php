<?php

namespace Transmission\Model;

class BandwidthGroup extends AbstractModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $honorsSessionLimits;

    /**
     * @var bool
     */
    protected $speedLimitDownEnabled;

    /**
     * @var int
     */
    protected $speedLimitDown;

    /**
     * @var bool
     */
    protected $speedLimitUpEnabled;

    /**
     * @var int
     */
    protected $speedLimitUp;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name)
    {
        $this->name = $name;
    }

    public function getHonorsSessionLimits(): ?bool
    {
        return $this->honorsSessionLimits;
    }

    public function setHonorsSessionLimits(?bool $honorsSessionLimits)
    {
        $this->honorsSessionLimits = $honorsSessionLimits;
    }

    public function getSpeedLimitDownEnabled(): ?bool
    {
        return $this->speedLimitDownEnabled;
    }

    public function setSpeedLimitDownEnabled(?bool $speedLimitDownEnabled)
    {
        $this->speedLimitDownEnabled = $speedLimitDownEnabled;
    }

    public function getSpeedLimitDown(): ?int
    {
        return $this->speedLimitDown;
    }

    public function setSpeedLimitDown(?int $speedLimitDown)
    {
        $this->speedLimitDown = $speedLimitDown;
    }

    public function getSpeedLimitUpEnabled(): ?bool
    {
        return $this->speedLimitUpEnabled;
    }

    public function setSpeedLimitUpEnabled(?bool $speedLimitUpEnabled)
    {
        $this->speedLimitUpEnabled = $speedLimitUpEnabled;
    }

    public function getSpeedLimitUp(): ?int
    {
        return $this->speedLimitUp;
    }

    public function setSpeedLimitUp(?int $speedLimitUp)
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

    /**
     * {@inheritdoc}
     */
    public static function getMapping(): array
    {
        return [
            'name'                       => 'name',
            'honorsSessionLimits'        => 'honorsSessionLimits',
            'speed-limit-down-enabled'   => 'speedLimitDownEnabled',
            'speed-limit-down'           => 'speedLimitDown',
            'speed-limit-up-enabled'     => 'speedLimitUpEnabled',
            'speed-limit-up'             => 'speedLimitUp',
        ];
    }
}