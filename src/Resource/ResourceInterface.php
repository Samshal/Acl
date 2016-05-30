<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl\Resource;

/**
 * interface ResourceInterface.
 *
 * Any class that creates a new Resource must obey this contract.
 *
 * @since 30/05/2016
 */
interface ResourceInterface
{
    /**
     * @param string resourceName
     */
    public function __construct($resourceName);

    /**
     * Returns the name of a Resource object.
     *
     * @throws {@todo create exception for 'invalid Resource object supplied'}
     *
     * @return string
     */
    public function getResourceName();
}
