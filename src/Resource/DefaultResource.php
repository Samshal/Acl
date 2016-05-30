<?php

declare(strict_type=1);
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
<<<<<<< HEAD
	/**
	 * @var string $resourceName
	 * @access protected
	 */
	protected $resourceName;
=======
    /**
     * @var string
     */
    protected $resourceName;
>>>>>>> 4437b1bc887583bcbb5bfb61109a97ee7020d5fa

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
