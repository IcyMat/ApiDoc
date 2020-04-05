<?php

namespace IcyMat\ApiDoc\Interfaces;

/**
 * Interface ParserInterface
 *
 * @package IcyMat\ApiDoc\Interfaces
 */
interface ParserInterface
{
    /**
     * @param $line
     * @return mixed
     */
    public static function parseLine($line);
}
