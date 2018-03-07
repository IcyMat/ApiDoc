<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;
use IcyMat\ApiDoc\Interfaces\ParserInterface;

/**
 * @Annotation
 */
class ApiResponse implements AnnotationInterface
{
    public $description = null;
    public $response = null;
}
