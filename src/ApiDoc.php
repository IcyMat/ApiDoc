<?php

namespace IcyMat\ApiDoc;

/**
 * Class ApiDoc
 *
 * @package IcyMat\ApiDoc
 */
class ApiDoc
{
    /**
     * @param $directory
     * @return array
     */
    public function generarteDoc($directory) : array
    {
        $files = $this->listDirectory($directory);

        $docData = [];

        $docGenerator = new DocReader(new CommentParser());
        foreach ($files as $file) {
            try {
                $results = $docGenerator->getDocCommentsForFile($file);

                if ($results !== null) {
                    $docData[] = $results;
                }
            } catch (\ReflectionException $exception) {
                continue;
            }
        }

        return $docData;
    }

    /**
     * @param string $directory
     * @param array $expectedExtensions
     * @return array
     */
    private function listDirectory(string $directory = '.', array $expectedExtensions = ['php']) : array
    {
        $result = [];
        if ($directory[strlen($directory) - 1] == '/') {
            $directory = substr($directory, 0, strlen($directory) - 1);
        }

        if ($o = opendir($directory)) {
            while (false !== ($file = readdir($o))) {
                if ($file == '.' || $file == '..' || $file[0] == '.') {
                    continue;
                } else if (is_dir($directory . '/' . $file)) {
                    $result = array_merge($result, $this->listDirectory($directory . '/' . $file));
                } else {
                    $fileExtension = explode('.', $file);
                    $fileExtension = end($fileExtension);

                    if (in_array($fileExtension, $expectedExtensions)) {
                        $result[] = $directory . '/' . $file;
                    }
                }
            }
            closedir($o);
        }

        return $result;
    }
}
