<?php

namespace Transmission\Util;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Transmission\Model\ModelInterface;

/**
 * The PropertyMapper is used to map responses from Transmission to models.
 */
class PropertyMapper
{
    public static function map(ModelInterface $model, \stdClass $dto): ModelInterface
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $mapping  = array_filter($model->getMapping(), function ($value) {
            return !is_null($value);
        });

        foreach ($mapping as $source => $dest) {
            try {
                $accessor->setValue(
                    $model,
                    $dest,
                    $accessor->getValue($dto, $source)
                );
            } catch (\Exception $e) {
            }
        }

        return $model;
    }
}
