<?php

namespace IcyMat\ApiDoc\Parser;

use IcyMat\ApiDoc\Interfaces\ParserInterface;

abstract class ApiRoute implements ParserInterface
{
    public static function parseLine($line)
    {
        $line = explode('ApiRoute(', $line);
        $line = substr($line[1], 0, strlen($line[1]) - 1);

        if ($line[strlen($line) - 1] == "'" || $line[strlen($line) - 1] == '"') {
            return substr($line, 1, strlen($line) - 2);
        }

        return $line;
    }
}
