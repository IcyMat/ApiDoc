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
        $methods = $reflectionClass->getMethods(
            \ReflectionMethod::IS_PUBLIC |
            \ReflectionMethod::IS_PROTECTED |
            \ReflectionMethod::IS_PRIVATE
        );

        foreach ($methods as $method) {
            echo "\t" . $method->getName() . "\n";
            $comment = $reflectionClass->getMethod($method->getName())->getDocComment();
            $parsedComment = $this->parseCommentToArray($comment);

            if (count($parsedComment) > 0) {
                $comments[] = $parsedComment;
            }
        }

        return $comments;
    }

    /**
     * @param $fileName
     * @return array|null
     * @throws \ReflectionException
     */
    public function getDocCommentsForFile($fileName): ?array
    {
        $className = $this->getClassNameFromFile($fileName);

        if ($className !== null) {
            return $this->getDocCommentsForClass($className);
        }

        return null;
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

        return $this->commentParser->parseComment($comment);
    }

    /**
     * @param $fileName
     * @return string
     */
    private function getClassNameFromFile($fileName) : string
    {
        $file = fopen($fileName, 'r');
        $namespace = null;

        if ($file !== false) {
            while (($line = fgets($file)) !== false) {
                $line = trim($line);
                $line = explode( ' ', $line);

                if ($line[0] == '') continue;

                if ($line[0] == 'namespace') {
                    $namespace = str_replace(';', '', $line[1]);
                }

                if ($line[0] == 'class' || $line[0] == 'interface' || $line[0] == 'trait' || (count($line) > 1 && $line[1] == 'abstract')) {
                    if ($line[1] == 'abstract') {
                        return $namespace . '\\' .  $line[2];
                    }

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
