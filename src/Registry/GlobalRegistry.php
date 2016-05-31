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
class GlobalRegistry extends Registry
{
	public function save($role, ...$options)
	{
		if (!isset($options[0])) throw new Exception("Resource parameter must be passed in as second argument to the save method");
		if (!isset($options[1])) throw new Exception("Permission parameter must be passed in as third argument to the save method");
		$resource = $options[0];
		$permission = $options[1];
		$status = (isset($options[2])) ? $options[2] : true;

		$this->registry[$role][$resource][$permission]["status"] = $status;
	}
}