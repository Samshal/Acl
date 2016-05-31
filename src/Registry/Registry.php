<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl\Registry;

/**
 * @since 30/05/2016
 */
abstract class Registry implements RegistryInterface
{
	protected $registry = [];

	public function save($object, ...$options)
	{
		if (!$this->exists($object))
		{
			$this->registry[$object] = [];
		}
	}

	public function remove($object)
	{
		if ($this->exists($object))
		{
			unset($this->registry[$object]);
		}
	}

	public function exists($object)
	{
		return (!empty($this->registry) && isset($this->registry[$object]));
	}

	public function get($object)
	{
		return ($this->exists($object)) ? $this->registry[$object] : null;
	}
}