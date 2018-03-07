<?php

namespace IcyMat\ApiDoc;

use IcyMat\ApiDoc\Parser\ApiDescription;
use IcyMat\ApiDoc\Parser\ApiMethod;
use IcyMat\ApiDoc\Parser\ApiParams;
use IcyMat\ApiDoc\Parser\ApiRoute;

class CommentParser
{
    public function parseComment(array $comment) : array
    {
        $resultData = [];

        foreach ($comment as $line) {
            $line = $this->parseLine($line);
            if ($line != '') {
                $resultData[] = $line;
            }
        }

        if (count($resultData) == 0) {
            return [];
        }

        return $this->createDocArrayFromComments($resultData);
    }

    public function parseLine($line)
    {
        $line = $this->cleanLine($line);

        return $line;
    }

    private function cleanLine($line) : string
    {
        $line = trim($line);

        if (strlen($line) == 0) return '';

        $textStartPosition = 0;
        while ($textStartPosition < strlen($line) && ($line[$textStartPosition] == ' ' || $line[$textStartPosition] == "\t" || $line[$textStartPosition] == '*')) {
            $textStartPosition++;
        }

        return substr($line, $textStartPosition, strlen($line) - 1);
    }

    private function parseLineAsDynamicValue(string $line) : array
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
        }

        return [
            'key' => '',
            'value' => null
        ];
    }

    private function createDocArrayFromComments(array $comments) : array
    {
        $resultData = [
            'route' => null,
            'methods' => null,
            'description' => null,
            'response' => null,
            'parameters' => []
        ];

        foreach ($comments as $line) {
            if ($line[0] == '@') {
                $dynamicValue = $this->parseLineAsDynamicValue($line);

                if ($dynamicValue['method'] == 'write') {
                    $resultData[$dynamicValue['key']] = $dynamicValue['value'];
                } else if ($dynamicValue['method'] == 'append') {
                    $resultData[$dynamicValue['key']][] = $dynamicValue['value'];
                }
            } else {
                $resultData['description'] .= $line;
            }
        }

        return $resultData;
    }
}