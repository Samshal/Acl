<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl;

/**
 * A contract that the Acl class must always obey
 *
 * @since 30/05/2016
 */
interface AclInterface
{
	/**
	 * Adds a new role object to the registry
	 *
	 * @param RoleInterface|string $role
	 * @return void
	 */
	public function addRole($role);

	/**
	 * Adds a new resource object to the registry
	 *
	 * @param ResourceInterface|string $resource
	 * @return void
	 */
	public function addResource($resource);

	/**
	 * Adds a new permission object to the registry
	 *
	 * @param PermissionInterface|string $permission
	 * @return void
	 */
	public function addPermission($permission);

	/**
	 * 
	 */
	public function add($object);

	/**
	 * 
	 */
	public function allow($role, $permission, $resource, $status=true);

	/**
	 * 
	 */
	public function deny($role, $permission, $resource);
}