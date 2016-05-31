<?php declare(strict_types=1);
/**
 * @license MIT
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */

namespace Samshal\Acl\Permission;

/**
 * interface PermissionInterface.
 *
 * Any class that creates a new Permission must obey this contract.
 *
 * @since 30/05/2016
 */
interface PermissionInterface
{
	/**
	 * @param string permissionName
	 */
	public function __construct($permissionName);

	/**
	 * Returns the name of a Permission object
	 *
	 * @throws {@todo create exception for 'invalid permission object supplied'}
	 * @return string
	 */
	public function getPermissionName();
}