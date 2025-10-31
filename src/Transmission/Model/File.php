<?php

namespace Transmission\Model;

class File extends AbstractModel
{
    protected ?string $name = null;

    protected ?int $size = null;

    protected ?int $completed = null;

    protected ?int $beginPiece = null;

    protected ?int $endPiece = null;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setCompleted(int $completed): void
    {
        $this->completed = $completed;
    }

    public function getCompleted(): ?int
    {
        return $this->completed;
    }

    public function isDone(): bool
    {
        return $this->getSize() == $this->getCompleted();
    }

    public function getBeginPiece(): ?int
    {
        return $this->beginPiece;
    }

    public function setBeginPiece(?int $beginPiece): void
    {
        $this->beginPiece = $beginPiece;
    }

    public function getEndPiece(): ?int
    {
        return $this->endPiece;
    }

    public function setEndPiece(?int $endPiece): void
    {
        $this->endPiece = $endPiece;
    }

    public static function getMapping(): array
    {
        return [
            'name'           => 'name',
            'length'         => 'size',
            'bytesCompleted' => 'completed',
            'begin_piece'    => 'beginPiece',
            'end_piece'      => 'endPiece',
        ];
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
