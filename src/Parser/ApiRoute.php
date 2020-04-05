<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * Class ApiRoute
 *
 * @package IcyMat\ApiDoc\Parser
 */
abstract class ApiRoute implements ParserInterface
{
    /**
     * @param $line
     * @return mixed
     */
    public static function parseLine($line)
    {
        $line = explode('ApiRoute(', $line);
        $line = substr($line[1], 0, strlen($line[1]) - 1);

        $parameters = self::parseParameters($line);

        return $parameters['name'];
    }

    /**
     * @param $parameters
     * @return array
     */
    private static function parseParameters($parameters)
    {
        $parameters = explode(', ', $parameters);
        $result = [
            'name' => null
        ];

        foreach ($parameters as $parameter) {
            $parameter = explode('=', $parameter);

            $result[$parameter[0]] = json_decode($parameter[1]);
        }

        return $result;
    }
}
