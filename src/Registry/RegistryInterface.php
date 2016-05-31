<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl\Registry;

/**
 * A contract that the Acl class must always obey
 *
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

	public function get($object);

}