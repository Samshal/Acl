<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl\Resource;

/**
 * class DefaultResource.
 *
 * A base object for creating new Resource objects
 *
 * @since 30/05/2016
 */
class DefaultResource implements ResourceInterface
{
    /**
     * @var string
     */
    protected $resourceName;

    /**
     * {@inheritdoc}
     */
    public function __construct($resourceName)
    {
        $this->resourceName = (string) $resourceName;
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * Returns the ResourceName when this class is treated as a string.
     */
    public function __toString()
    {
        return $this->getResourceName();
    }
}
