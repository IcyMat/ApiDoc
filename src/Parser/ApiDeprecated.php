<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * Class ApiDeprecated
 *
 * @package IcyMat\ApiDoc\Parser
 */
abstract class ApiDeprecated implements ParserInterface
{
    /**
     * @param $line
     * @return array|mixed
     */
    public static function parseLine($line)
    {
        $line = explode('ApiDeprecated(', $line);
        $line = substr($line[1], 0, strlen($line[1]) - 1);

        return self::parseParameters($line);
    }

    /**
     * @param $parameters
     * @return array
     */
    private static function parseParameters($parameters)
    {
        $parameters = str_replace(':', '[_ICYMAT_API_DOC_COLON_]', $parameters);
        $parameters = str_replace('="', ':"', $parameters);
        $parameters = self::createJson($parameters);
        $parameters = str_replace('[_ICYMAT_API_DOC_COLON_]', ':', $parameters);

        return json_decode($parameters, true);
    }

    /**
     * @param $json
     * @return string
     */
    private static function createJson($json): string
    {
        $json = str_replace("'", '"', $json);
        $json = preg_replace('/(\w+):/i', '"\1":', $json);

        return sprintf('{%s}', $json);
    }
}
