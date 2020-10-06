<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiRouteParams implements AnnotationInterface
{
    /**
     * @var string
     */
    public $name = null;

    /**
     * @var string
     */
    public $type = null;

    /**
     * @var string
     */
    public $description = '';

    /**
     * @var bool
     */
    public $required = true;
}
