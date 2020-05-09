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
     * {@inheritdoc}
     */
    public static function getMapping(): array
    {
        return [
            'path'       => 'path',
            'size-bytes' => 'size',
        ];
    }
}
