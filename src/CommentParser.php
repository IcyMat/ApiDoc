<?php

namespace IcyMat\ApiDoc;

/**
 * Class CommentParser
 *
 * @package IcyMat\ApiDoc
 */
class CommentParser
{

    /**
     * @param array $comment
     * @return array
     */
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
        $doc = $this->createDocArrayFromComments($resultData);

        if ($doc === null) {
            return [];
        }

		return $doc;
	}

    /**
     * @param $line
     * @return string
     */
    public function parseLine($line)
	{
		$line = $this->cleanLine($line);

		return $line;
	}

    /**
     * @param $line
     * @return string
     */
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

    /**
     * @param array $comments
     * @return array|null
     */
    private function createDocArrayFromComments(array $comments): ?array
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

				if ($dynamicValue === null) {
				    continue;
                }

				if ($dynamicValue['method'] == 'write') {
					$resultData[$dynamicValue['key']] = $dynamicValue['value'];
				} else if ($dynamicValue['method'] == 'append') {
					$resultData[$dynamicValue['key']][] = $dynamicValue['value'];
				}
			} else if ($resultData['description'] !== null) {
				$resultData['description'] .= $line;
			}
		}

		if ($resultData['route'] == null) {
		    return null;
        }

		return $resultData;
	}

    /**
     * @param $resultData
     * @return array
     */
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
