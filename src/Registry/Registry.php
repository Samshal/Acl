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
 * Class Registry
 *
 * @package samshal.acl.registry
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @since 30/05/2016
 */
abstract class Registry implements RegistryInterface
{
    /**
     * @var array $registry
     */
    protected $registry = [];

    /**
     * Saves an object to the registry
     *
     * @param string $object
     * @param variadic $options
     * @return void
     */
    public function save($object, ...$options)
    {
        if (!$this->exists($object)) {
            $this->registry[$object] = [];
        }

        return;
    }

    /**
     * removes an object from the registry
     *
     * @param string $object
     * @return void
     */
    public function remove($object)
    {
        if ($this->exists($object)) {
            unset($this->registry[$object]);
        }

        return;
    }

    /**
     * determines if an object exists in the registry
     *
     * @param string $object
     * @return boolean
     */
    public function exists($object)
    {
        return (!empty($this->registry) && isset($this->registry[$object]));
    }

    /**
     * retrieves an object index from the registry
     *
     * @param string $object
     * @return mixed
     */
    public function get($object)
    {
        return ($this->exists($object)) ? $this->registry[$object] : null;
    }
}
