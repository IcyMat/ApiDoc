<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;
use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * @Annotation
 */
class ApiRoute implements AnnotationInterface
{
    public $name = null;
}
