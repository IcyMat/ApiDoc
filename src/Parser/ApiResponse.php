<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * Class ApiResponse
 *
 * @package IcyMat\ApiDoc\Parser
 */
abstract class ApiResponse implements ParserInterface
{
    /**
     * @param $line
     * @return array|mixed
     */
    public static function parseLine($line)
    {
        $line = explode('ApiResponse(', $line);
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

        $parameters = [
        	array_shift($parameters),
			implode(', ', $parameters)
		];

        $result = [
            'description' => null,
            'response' => null
        ];

        foreach ($parameters as $parameter) {
            $parameter = explode('=', $parameter);

            if ($parameter[0] == 'description') {
				$result['description'] = json_decode($parameter[1]);
			} else if ($parameter[0] == 'response') {
				$result['response'] = substr($parameter[1], 1, strlen($parameter[1]) - 2);
			}
        }

		$result['response'] = str_replace("'", '"', $result['response']);

        return $result;
    }
}
