<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiResponse implements AnnotationInterface
{
    /**
     * @var null
     */
    public $description = null;

    /**
     * @var null
     */
    public $response = null;
}
