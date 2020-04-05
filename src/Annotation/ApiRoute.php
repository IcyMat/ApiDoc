<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiRoute implements AnnotationInterface
{
    /**
     * @var null
     */
    public $name = null;
}
