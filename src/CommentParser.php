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

		$resultData = $this->concatenateMultiLineAnnotation($resultData);

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

	private function createDocArrayFromComments(array $comments) : array
	{
		$resultData = [
			'route' => null,
			'methods' => null,
			'description' => null,
			'response' => [],
			'parameters' => []
		];

		$annotationParser = new AnnotationParser();

		foreach ($comments as $line) {
			if ($line[0] == '@') {
				$dynamicValue = $annotationParser->parseAnnotationLine($line);

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

	private function concatenateMultiLineAnnotation($resultData) : array
	{
		$newArray = [];
		$newIndex = 0;

		$inObject = false;
		foreach ($resultData as $line) {
			if ($line[0] === '@') {
				$newArray[$newIndex] = stripslashes($line);

				if ($line[strlen($line) - 1] !== ')') {
					$inObject = true;
					continue;
				}
			}

			if ($inObject) {
				$newArray[$newIndex] .= stripslashes($line);

				if ($line[strlen($line) - 1] == ')') {
					$newIndex++;
					$inObject = false;
				}

				continue;
			}

			$newArray[$newIndex] = stripslashes($line);

			if (!$inObject) {
				$newIndex++;
			}
		}

		return $newArray;
	}
}
