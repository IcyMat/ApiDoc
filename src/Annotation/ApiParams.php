<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;
use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * @Annotation
 */
class ApiParams implements AnnotationInterface
{
    public $name = null;
    public $type = null;
    public $nullable = false;
    public $description = '';
    public $required = true;
}
