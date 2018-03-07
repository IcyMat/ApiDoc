<?php

namespace IcyMat\ApiDoc;

class ApiDoc
{
    public function generarteDoc($directory)
    {
        $files = $this->listDirectory($directory);

        $docGenerator = new DocReader(new CommentParser());
        foreach ($files as $file) {
            $docGenerator->getDocCommentsForFile($file);
        }
    }

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
                    $result[] = $this->listDirectory($directory . '/' . $file);
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
