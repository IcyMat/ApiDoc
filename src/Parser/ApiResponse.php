<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

abstract class ApiResponse implements ParserInterface
{
    public static function parseLine($line)
    {
        $line = explode('ApiResponse(', $line);
        $line = substr($line[1], 0, strlen($line[1]) - 1);

        return self::parseParameters($line);
    }

    private static function parseParameters($parameters)
    {
        $parameters = explode(', ', $parameters);
        $result = [
            'description' => null,
            'response' => null
        ];

        foreach ($parameters as $parameter) {
            $parameter = explode('=', $parameter);

            if ($parameter[0] == 'response') {
				$result[$parameter[0]] = substr($parameter[1], 1, strlen($parameter[1]) - 2);
			} else {
				$result[$parameter[0]] = json_decode($parameter[1]);
			}
        }

        return $result;
    }
}
