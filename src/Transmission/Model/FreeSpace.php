<?php

namespace Transmission\Model;

class FreeSpace extends AbstractModel
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $totalSize;

    /**
     * Gets the value of path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the value of path.
     *
     * @param string $path the path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Gets the value of size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets the value of size.
     *
     * @param int $size the size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Gets the value of totalSize.
     *
     * @return int
     */
    public function getTotalSize()
    {
        return $this->totalSize;
    }

    /**
     * Sets the value of totalSize.
     *
     * @param int $totalSize the total size
     */
    public function setTotalSize($totalSize)
    {
        $this->totalSize = $totalSize;
    }

    /**
     * {@inheritdoc}
     */
    public static function getMapping(): array
    {
        return [
            'path'       => 'path',
            'size-bytes' => 'size',
            'total_size' => 'totalSize',
        ];
    }
}
