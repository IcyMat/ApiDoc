<?php

namespace IcyMat\ApiDoc\Annotation;

use IcyMat\ApiDoc\Interfaces\AnnotationInterface;

/**
 * @Annotation
 */
class ApiParams implements AnnotationInterface
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
     * @var bool
     */
    public $nullable = false;

    /**
     * @var string
     */
    public $description = '';

    /**
     * @var bool
     */
    public $required = true;
}
