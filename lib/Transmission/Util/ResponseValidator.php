<?php

namespace Transmission\Util;

use Transmission\Model\ModelInterface;

class ResponseValidator
{
    /**
     * @return \stdClass|array
     */
    public static function validate(string $method, \stdClass $response)
    {
        if (!isset($response->result)) {
            throw new \RuntimeException('Invalid response received from Transmission');
        }

        if (!in_array($response->result, ['success', 'duplicate torrent'])) {
            throw new \RuntimeException(sprintf('An error occured: "%s"', $response->result));
        }

        switch ($method) {
            case 'torrent-get':
                return self::validateGetResponse($response);
            case 'torrent-add':
                return self::validateAddResponse($response);
            case 'session-get':
                return self::validateSessionGetResponse($response);
            case 'session-stats':
                return self::validateSessionStatsGetResponse($response);
            case 'free-space':
                return self::validateFreeSpaceGetResponse($response);
        }
    }

    /**
     * @throws \RuntimeException
     */
    public static function validateGetResponse(\stdClass $response): array
    {
        if (
            !isset($response->arguments) ||
            !isset($response->arguments->torrents)
        ) {
            throw new \RuntimeException('Invalid response received from Transmission');
        }

        return $response->arguments->torrents;
    }

    /**
     * @throws \RuntimeException
     */
    public static function validateAddResponse(\stdClass $response)
    {
        $fields = ['torrent-added', 'torrent-duplicate'];

        foreach ($fields as $field) {
            if (
                isset($response->arguments) &&
                isset($response->arguments->$field) &&
                count((array) $response->arguments->$field)
            ) {
                return $response->arguments->$field;
            }
        }

        throw new \RuntimeException('Invalid response received from Transmission');
    }

    /**
     * @throws \RuntimeException
     */
    public static function validateSessionGetResponse(\stdClass $response): \stdClass
    {
        if (!isset($response->arguments)) {
            throw new \RuntimeException('Invalid response received from Transmission');
        }

        return $response->arguments;
    }

    /**
     * @throws \RuntimeException
     */
    public static function validateSessionStatsGetResponse(\stdClass $response): \stdClass
    {
        if (!isset($response->arguments)) {
            throw new \RuntimeException('Invalid response received from Transmission');
        }
        $class = 'Transmission\Model\Stats\Stats';
        foreach (['cumulative-stats', 'current-stats'] as $property) {
            if (property_exists($response->arguments, $property)) {
                $instance                       = self::map($response->arguments->$property, $class);
                $response->arguments->$property = $instance;
            }
        }

        return $response->arguments;
    }

    private static function map(\stdClass $object, string $class): ModelInterface
    {
        return PropertyMapper::map(new $class(), $object);
    }

    /**
     * @throws \RuntimeException
     */
    public static function validateFreeSpaceGetResponse(\stdClass $response)
    {
        if (!isset($response->arguments)) {
            throw new \RuntimeException('Invalid response received from Transmission');
        }

        return $response->arguments;
    }
}
