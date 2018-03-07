<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiDescription implements AnnotationInterface
{
    public $section = null;
    public $description = '';
}
