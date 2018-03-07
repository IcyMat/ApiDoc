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
            'name' => null,
            'response' => null
        ];

        foreach ($parameters as $parameter) {
            $parameter = explode('=', $parameter);

            if ($parameter[0] == 'type') {
                $result[$parameter[0]] = self::parseType($parameter[1]);
            } else if ($parameter[0] == 'nullable' || $parameter[0] == 'required') {
                $result[$parameter[0]] = self::parseBoolean($parameter[1]);
            } else {
                $result[$parameter[0]] = json_decode($parameter[1]);
            }
        }

        return $result;
    }

    private static function parseType($type) {
        $type = str_replace('"', '', $type);
        $type = str_replace("'", '', $type);

        switch ($type) {
            case 'int':
            case 'integer':
                return 'integer';

            case 'bool':
            case 'boolean':
                return 'boolean';

            default:
                return $type;
        }
    }

    private static function parseBoolean($type) {
        $type = str_replace('"', '', $type);
        $type = str_replace("'", '', $type);

        return $type == 'false' ? false : true;
    }
}
