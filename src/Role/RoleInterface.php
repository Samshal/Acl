<?php declare (strict_types=1);

/**
 * This file is part of the Samshal\Acl library
 *
 * @license MIT
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl\Role;

/**
 * Interface RoleInterface.
 *
 * Any class that creates a new Role must obey this contract.
 *
 * @package samshal.acl.role
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @since 30/05/2016
 */
interface RoleInterface
{
    /**
     * @param string roleName
     */
    public function __construct($roleName);

    /**
     * Returns the name of a Role object.
     *
     * @throws {@todo create exception for 'invalid role object supplied'}
     *
     * @return string
     */
    public function getRoleName();
}
