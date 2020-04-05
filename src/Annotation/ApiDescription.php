<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiDescription implements AnnotationInterface
{
    /**
     * @var null
     */
    public $section = null;

    /**
     * @var string
     */
    public $description = '';
}
