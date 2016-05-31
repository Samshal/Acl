<?php
declare (strict_types=1);

/**
 * This file is part of the Samshal\Acl library
 *
 * @license MIT
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl\Registry;

/**
 * Interface RegistryInterface.
 * A contract that all Registry must always obey
 *
 * @package samshal.acl.registry
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @since 30/05/2016
 */
interface RegistryInterface
{
    /**
     * Adds a new value to the global registry 
     *
     * @param string $object
     * @return void
     */
    public function save($object, ...$options);

    /**
     * remves an object from the global registry
     *
     * @param string $object
     * @return void
     */
    public function remove($object);

    /**
     * determines if an object exists in the global registry
     *
     * @param string $object
     * @return boolean
     */
    public function exists($object);

    /**
     * retrieves an object index from the registry
     *
     * @param string $object
     * @return mixed
     */
    public function get($object);
}
