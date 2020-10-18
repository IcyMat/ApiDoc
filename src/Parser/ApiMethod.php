<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * Class ApiMethod
 *
 * @package IcyMat\ApiDoc\Parser
 */
abstract class ApiMethod implements ParserInterface
{
    /**
     * @param $line
     * @return mixed
     */
    public static function parseLine($line)
    {
        $lines = explode('@ApiMethod', $line);
        $methods = [];

        foreach ($lines as $line) {
            $line = trim($line);
            $line = substr($line, 1, strlen($line) - 2);
            $method = self::parseParameters($line);

            if ($method !== null) {
                $methods[] = $method;
            }
        }

        if (count($methods) == 0) {
            return null;
        }

        return $methods;
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
        $parameters = json_decode($parameters, true);

        if (isset($parameters['method'])) {
            return $parameters['method'];
        }

        return null;
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
