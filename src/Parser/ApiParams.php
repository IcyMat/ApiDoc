<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * Class ApiParams
 *
 * @package IcyMat\ApiDoc\Parser
 */
abstract class ApiParams implements ParserInterface
{
    /**
     * @param $line
     * @return array|mixed
     */
    public static function parseLine($line)
    {
        $line = explode('ApiParams(', $line);
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
            'name' => null,
            'type' => null,
            'nullable' => false,
            'description' => '',
            'required' => true
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

    /**
     * @param $type
     * @return string|string[]
     */
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

    /**
     * @param $type
     * @return bool
     */
    private static function parseBoolean($type) {
        $type = str_replace('"', '', $type);
        $type = str_replace("'", '', $type);

        return $type == 'false' ? false : true;
    }
}
