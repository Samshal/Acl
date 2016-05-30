<?php declare(strict_types=1);
/**
 * @license MIT
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */

namespace Samshal\Acl\Role;

/**
 * interface RoleInterface.
 *
 * Any class that creates a new Role must obey this contract.
 *
 * @since 30/05/2016
 */
interface RoleInterface
{
	/**
	 * @param string roleName
	 */
	public function __construct($roleName);

	/**
	 * Returns the name of a Role object
	 *
	 * @throws {@todo create exception for 'invalid role object supplied'}
	 * @return string
	 */
	public function getRoleName();
}