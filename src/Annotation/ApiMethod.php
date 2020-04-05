<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiMethod implements AnnotationInterface
{
    /**
     * @var array
     */
    public $method = [];
}
