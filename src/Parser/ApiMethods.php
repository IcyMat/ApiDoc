<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

abstract class ApiMethods implements ParserInterface
{
    public static function parseLine($line)
    {
        $line = explode('ApiMethods(', $line);
        $line = substr($line[1], 0, strlen($line[1]) - 1);

        $methods = json_decode($line, true);

        foreach ($methods as $x => $method) {
            $methods[$x] = strtoupper($method);
        }

        return $methods;
    }
}
