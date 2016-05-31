<?php declare (strict_types=1);

/**
 * This file is part of the Samshal\Acl library
 *
 * @license MIT
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl;

/**
 * Interface AclInterface.
 *
 * A contract that the Acl class must always obey
 *
 * @package samshal.acl
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
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
     * Adds objects lazily.
     *
     * Automatically determine the type of an object and call the appropriate
     * add method on it.
     *
     * @param RoleInterface|ResourceInterface|PermissionInterface $object
     * @throws \Exception
     * @return void
     */
    public function add($object);

    /**
     * Change the status option of an assigned permission to true
     *
     * @param RoleInterface|string $role;
     * @param PermissionInterface|string $permission
     * @param ResourceInterface|string $resource
     * @param boolean $status Optional
     * @throws \Exception
     * @return void
     */
    public function allow($role, $permission, $resource, $status=true);

    /**
     * Change the status option of an assigned permission to false
     *
     * @param RoleInterface|string $role;
     * @param PermissionInterface|string $permission
     * @param ResourceInterface|string $resource
     * @return void
     */
    public function deny($role, $permission, $resource);
}
