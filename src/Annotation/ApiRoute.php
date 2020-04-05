<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiRoute implements AnnotationInterface
{
    /**
     * @var string
     */
    public $name = null;
}
