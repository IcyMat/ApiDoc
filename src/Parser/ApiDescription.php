<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * Class ApiDescription
 *
 * @package IcyMat\ApiDoc\Parser
 */
abstract class ApiDescription implements ParserInterface
{
    /**
     * @param $line
     * @return array|mixed
     */
    public static function parseLine($line)
    {
        $line = explode('ApiDescription(', $line);
        $line = substr($line[1], 0, strlen($line[1]) - 1);

        return self::parseParameters($line);
    }

    /**
     * @param $parameters
     * @return array
     */
    private static function parseParameters($parameters)
    {
        $parameters = explode(', ', $parameters);
        $result = [
            'section' => null,
            'description' => null
        ];

        foreach ($parameters as $parameter) {
            $parameter = explode('=', $parameter);
            $result[$parameter[0]] = json_decode($parameter[1]);
        }

        return $result;
    }
}
