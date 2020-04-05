<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiResponse implements AnnotationInterface
{
    /**
     * @var string
     */
    public $description = null;

    /**
     * @var string
     */
    public $response = null;
}
