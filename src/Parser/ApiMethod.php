<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

abstract class ApiMethod implements ParserInterface
{
    public static function parseLine($line)
    {
        $line = explode('ApiMethod(', $line);
        $line = substr($line[1], 0, strlen($line[1]) - 1);

        $method = self::parseParameters($line);

        return $method['method'];
    }

    private static function parseParameters($parameters)
    {
        $parameters = explode(', ', $parameters);
        $result = [
            'method' => 'GET'
        ];

        foreach ($parameters as $parameter) {
            $parameter = explode('=', $parameter);

            $result[$parameter[0]] = strtoupper(json_decode($parameter[1]));
        }

        return $result;
    }
}