<?php

namespace Transmission\Model;

class FreeSpace extends AbstractModel
{
    private ?string $path = null;

    private ?int $size = null;

    private ?int $totalSize = null;

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getTotalSize(): ?int
    {
        return $this->totalSize;
    }

    public function setTotalSize(int $totalSize): void
    {
        $this->totalSize = $totalSize;
    }

    public static function getMapping(): array
    {
        return [
            'path'       => 'path',
            'size-bytes' => 'size',
            'total_size' => 'totalSize',
        ];
    }
}
