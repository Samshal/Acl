<?php declare (strict_types=1);

/**
 * This file is part of the Samshal\Acl library
 *
 * @license MIT
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl\Permission;

/**
 * class DefaultPermission.
 *
 * @package samshal.acl.permission
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @since 30/05/2016
 */
class DefaultPermission implements PermissionInterface
{
    /**
     * @var string $permissionName
     * @access protected
     */
    protected $permissionName;

    /**
     * {@inheritdoc}
     */
    public function __construct($permissionName)
    {
        $this->permissionName = (string)$permissionName;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissionName()
    {
        return $this->permissionName;
    }

    /**
     * Returns the permissionName when this class is treated as a string
     */
    public function __toString()
    {
        return $this->getPermissionName();
    }
}
