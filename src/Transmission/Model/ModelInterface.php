<?php

namespace Transmission\Model;

/**
 * The interface Transmission models must implement.
 */
interface ModelInterface
{
    /**
     * Get the mapping of the model.
     */
    public static function getMapping(): array;
}
