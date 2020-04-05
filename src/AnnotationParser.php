<?php

namespace IcyMat\ApiDoc;

use IcyMat\ApiDoc\Parser\ApiDescription;
use IcyMat\ApiDoc\Parser\ApiMethod;
use IcyMat\ApiDoc\Parser\ApiParams;
use IcyMat\ApiDoc\Parser\ApiResponse;
use IcyMat\ApiDoc\Parser\ApiRoute;

/**
 * Class AnnotationParser
 *
 * @package IcyMat\ApiDoc
 */
class AnnotationParser
{
    /**
     * @param string $line
     * @return array|null
     */
    public function parseAnnotationLine(string $line): ?array
	{
		$type = explode('(', $line);

		switch ($type[0]) {
			case '@ApiRoute':
				return [
					'key' => 'route',
					'value' => ApiRoute::parseLine($line),
					'method' => 'write'
				];

			case '@ApiMethod':
				return [
					'key' => 'methods',
					'value' => ApiMethod::parseLine($line),
					'method' => 'append'
				];

			case '@ApiParams':
				return [
					'key' => 'parameters',
					'value' => ApiParams::parseLine($line),
					'method' => 'append'
				];

			case '@ApiDescription':
				return [
					'key' => 'description',
					'value' => ApiDescription::parseLine($line),
					'method' => 'write'
				];

			case '@ApiResponse':
				return [
					'key' => 'response',
					'value' => ApiResponse::parseLine($line),
					'method' => 'append'
				];
		}

		return null;
	}
}
