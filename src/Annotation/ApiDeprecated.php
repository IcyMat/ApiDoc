<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiDeprecated implements AnnotationInterface
{
    /**
     * @var string
     */
    public $description = '';
}
