<?php

namespace IcyMat\ApiDoc\Twig;

/**
 * Class JsonFormatterExtension
 *
 * @package IcyMat\ApiDoc\Twig
 */
class JsonFormatterExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
	{
		return [
			new \Twig_Filter('jsonFormatter', [$this, 'jsonFormatter'], ['is_safe' => ['html']])
		];
	}

    /**
     * @param string $jsonString
     * @return string
     */
    public function jsonFormatter(string $jsonString) : string {
		$jsonData = json_decode($jsonString, true);

		if ($jsonData === null) {
			return '';
		}

		return $this->parseJson($jsonData);
	}

    /**
     * @return string
     */
    public function getName()
	{
		return 'icymat_apidoc_json_formatter';
	}

    /**
     * @param array $jsonData
     * @param int $tabSize
     * @return string
     */
    private function parseJson(array $jsonData, $tabSize = 4) : string
	{
		if ($this->arrayIsAssoc($jsonData)) {
			$string = '{<br>';
		} else {
			$string = '[<br>';
		}

		$tab = '';
		for ($x = 0; $x < $tabSize; $x++) {
			$tab .= ' ';
		}

		foreach ($jsonData as $key => $value) {
			if (is_int($key)) {
				$string .= $tab;
			} else {
				$string .= $tab . '<span style="color: #000; font-weight: 700;">' . $key . '</span>: ';
			}

			if (is_array($value)) {
				$string .= $this->parseJson($value, $tabSize + 4) . ',<br>';
				continue;
			}

			if (is_numeric($value)) {
				$string .= '<span style="color: #008;">' . $value . '</span>,';
			} else if (is_bool($value)) {
				$string .= '<span style="color: #400;">' . ($value ? 'true' : 'false') . '</span>,';
			} else if ($value === null) {
				$string .= '<span style="color: #aaa;">null</span>,';
			} else {
				$string .= '<span style="color: #060;">"' . addslashes($value) . '"</span>,';
			}

			$string .= '<br>';
		}


		if ($this->arrayIsAssoc($jsonData)) {
			return $string . (substr($tab, 0, $tabSize - 4)) . '}';
		} else {
			return $string . (substr($tab, 0, $tabSize - 4)) . ']';
		}
	}

    /**
     * @param array $arr
     * @return bool
     */
    private function arrayIsAssoc(array $arr) : bool
	{
		if (array() === $arr) return false;

		return array_keys($arr) !== range(0, count($arr) - 1);
	}
}
