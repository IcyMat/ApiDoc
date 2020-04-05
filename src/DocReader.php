<?php

namespace IcyMat\ApiDoc;

/**
 * Class DocReader
 *
 * @package IcyMat\ApiDoc
 */
class DocReader
{

    /**
     * @var CommentParser
     */
    private $commentParser;

    /**
     * DocReader constructor.
     *
     * @param CommentParser $commentParser
     */
    public function __construct(CommentParser $commentParser)
    {
        $this->commentParser = $commentParser;
    }

    /**
     * @param $className
     * @return array
     * @throws \ReflectionException
     */
    public function getDocCommentsForClass($className) : array
    {
        try {
            $reflectionClass = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            return [];
        }

        $comments = [];

        foreach (get_class_methods($className) as $methodName) {
            $comment = $reflectionClass->getMethod($methodName)->getDocComment();
            $parsedComment = $this->parseCommentToArray($comment);

            if (count($parsedComment) > 0) {
                $comments[] = $this->parseCommentToArray($comment);
            }
        }

        return $comments;
    }

    /**
     * @param $fileName
     * @return array
     * @throws \ReflectionException
     */
    public function getDocCommentsForFile($fileName)
    {
        return $this->getDocCommentsForClass(
            $this->getClassNameFromFile($fileName)
        );
    }

    /**
     * @param $comment
     * @return array
     */
    private function parseCommentToArray($comment) : array
    {
        $comment = explode("\n", $comment);
        array_shift($comment);
        unset($comment[count($comment) - 1]);

        $comment = $this->commentParser->parseComment($comment);

        return $comment;
    }

    /**
     * @param $fileName
     * @return string
     */
    private function getClassNameFromFile($fileName) : string
    {
        $file = fopen($fileName, 'r');
        $namespace = null;
        $objectName = null;

        if ($file !== false) {
            while (($line = fgets($file)) !== false) {
                $line = trim($line);
                $line = explode( ' ', $line);

                if ($line[0] == '') continue;

                if ($line[0] == 'namespace') {
                    $namespace = str_replace(';', '', $line[1]);
                }

                if ($line[0] == 'class' || $line[0] == 'interface' || $line[0] == 'trait') {
                    return $namespace . '\\' .  $line[1];
                }

                if (count($line) > 1 && $line[1] == 'class') {
                    return $namespace . '\\' .  $line[2];
                }
            }
        }

        return null;
    }
}
