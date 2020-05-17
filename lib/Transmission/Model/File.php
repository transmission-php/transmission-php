<?php

namespace Transmission\Model;

class File extends AbstractModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var int
     */
    protected $completed;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = (int) $size;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    public function setCompleted($completed)
    {
        $this->completed = (int) $completed;
    }

    /**
     * @return int
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->getSize() == $this->getCompleted();
    }

    /**
     * {@inheritdoc}
     */
    public static function getMapping(): array
    {
        return [
            'name'           => 'name',
            'length'         => 'size',
            'bytesCompleted' => 'completed',
        ];
    }

    public function __toString()
    {
        return $this->name;
    }
}
