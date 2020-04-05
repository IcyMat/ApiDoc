<?php

namespace IcyMat\ApiDoc\Docs;

/**
 * Class DocumentationGenerator
 *
 * @package IcyMat\ApiDoc\Docs
 */
class DocumentationGenerator
{
    /**
     * @param array $data
     * @return array
     */
    public function createDocData(array $data) : array
	{
		$docData = [];

		foreach ($data as $methods) {
			foreach ($methods as $method) {
				if (count($method['description']) == 0) {
					$method['description'] = [
						'section' => 'Default',
						'description' => null
					];
				}

				$slug = $this->createSlug($method['description']['section']);
				if (!array_key_exists($slug, $docData)) {
					$docData[$slug] = [
						'section' => [
							'name' => $method['description']['section'],
							'slug' => $slug
						],
						'methods' => []
					];
				}

				$docData[$slug]['methods'][] = $method;
			}
		}

		return $docData;
	}

    /**
     * @param string $name
     * @return string
     */
    private function createSlug(string $name) : string
	{
		return str_replace(' ', '-', strtolower($name));
	}
}
