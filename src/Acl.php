<?php
declare(strict_types=1);

/**
 * This file is part of the Samshal\Acl library
 *
 * @license MIT
 * @copyright Copyright (c) 2016 Samshal http://samshal.github.com
 */
namespace Samshal\Acl;

use Samshal\Acl\Role\{
	DefaultRole as Role,
	RoleInterface
};
use Samshal\Acl\Resource\{
	DefaultResource as Resource,
	ResourceInterface
};
use Samshal\Acl\Permission\{
	DefaultPermission as Permission,
	PermissionInterface
};
use Samshal\Acl\Registry\{
	GlobalRegistry,
	RoleRegistry,
	ResourceRegistry,
	PermissionRegistry
};


/**
 * Class Acl
 *
 * @package samshal.acl
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
 * @since 30/05/2016
 */
class Acl implements AclInterface
{
	/**
	 * @var RegistryInterface $roleRegistry
	 */
	public $roleRegistry;

	/**
	 * @var RegistryInterface $resourceRegistry
	 */
	protected $resourceRegistry;

	/**
	 * @var RegistryInterface $permissionRegistry
	 */
	protected $permissionRegistry;

	/**
	 * @var RegistryInterface $globalRegistry
	 */
	public $globalRegistry;

	/**
	 *  @var string[] $sesion
	 */
	protected $session = [];

	/**
	 * @var string SYN_ALLOW
	 */
	const SYN_ALLOW = "can";

	/**
	 * @var string SYN_DENY
	 */
	const SYN_DENY = "cannot";

	/**
	 * Performs bootstrapping
	 */
	public function __construct()
	{
		self::initRegistries();
		self::initSession();
	}

	/**
	 * Initalizes the registries
	 *
	 * @return void
	 */
	protected function initRegistries()
	{
		$this->roleRegistry = new RoleRegistry();
		$this->resourceRegistry = new ResourceRegistry();
		$this->permissionRegistry = new PermissionRegistry();
		$this->globalRegistry = new GlobalRegistry();

		return;
	}

	/**
	 * Initializes the global session array and sets them to the default value
	 *
	 * @return void 
	 */
	protected function initSession()
	{
		$this->session["query"] = true;
		unset($this->session["role"], $this->session["status"]);

		return;
	}

	/**
	 * Listen for and intercept properties that're not set
	 *
	 * @param string|RoleInterface $role;
	 * @throws \Exception
	 * @return AclInterface 
	 */
	public function __get($role)
	{
		if ($role === self::SYN_ALLOW || $role === self::SYN_DENY)
		{
			$this->session["status"] = ($role === self::SYN_ALLOW) ? true : false;

			if (!empty($this->session["role"]))
			{
				$this->session["query"] = false;
			}

			return $this;
		}

		if (!$this->roleRegistry->exists($role)) throw new \Exception(sprintf("The role: %s doesnt exist", (string)$role));

		$this->session["role"] = $role;

		return $this;
	}

	/**
	 * Listen for and intercept undefined methods
	 *
	 * @param string|PermissionInterface $permission
	 * @param string[]|ResourceInterface[] $args
	 * @throws \Exception
	 * @return void
	 */
	public function __call($permission, $args)
	{
		if (!$this->permissionRegistry->exists($permission)) throw new \Exception(sprintf("The permission: %s doesnt exist", (string)$permission));
		if (!$this->resourceRegistry->exists($args[0])) throw new \Exception(sprintf("The resource: %s doesnt exist", (string)$args[0]));

		if ($this->session["query"])
		{
			$result = $this->getPermissionStatus($this->session["role"], $permission, $args[0]);
			$this->initSession();
			return $result;
		}

		$this->allow($this->session["role"], $permission, $args[0], $this->session["status"]);
		$this->initSession();

		return;
	}

	/**
	 * Add a new role object to the registry
	 *
	 * @param RoleInterface|string $role
	 * @return void
	 */
	public function addRole($role)
	{
		if ($role instanceof RoleInterface)
		{
			$role = (string)$role;
		}

		$this->roleRegistry->save($role);

		return;
	}

	/**
	 * Add a new resource object to the registry
	 *
	 * @param ResourceInterface|string $resource
	 * @return void
	 */
	public function addResource($resource)
	{
		if ($resource instanceof ResourceInterface)
		{
			$resource = (string)$resource;
		}

		$this->resourceRegistry->save($resource);

		return;
	}

	/**
	 * Add a new permission object to the registry
	 *
	 * @param PermissionInterface|string $permission
	 * @return void
	 */
	public function addPermission($permission)
	{
		if ($permission instanceof PermissionInterface)
		{
			$permission = (string)$permission;
		}

		$this->permissionRegistry->save($permission);

		return;
	}

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
	public function add($object)
	{
		if ($object instanceof RoleInterface)
		{
			$this->addRole($object);
		}
		else if ($object instanceof ResourceInterface)
		{
			$this->addResource($object);
		}
		else if ($object instanceof PermissionInterface)
		{
			$this->addPermission($object);
		}
		else throw new \Exception(sprintf("%s must implement one of RoleInterface, ResourceInterface and PermissionInterface", $object));

		return;
	}

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
	public function allow($role, $permission, $resource, $status=true)
	{
		if (!$this->roleRegistry->exists($role)) throw new \Exception(sprintf("The role: %s doesnt exist", (string)$role));
		if (!$this->permissionRegistry->exists($permission)) throw new \Exception(sprintf("The permission: %s doesnt exist", (string)$permission));
		if (!$this->resourceRegistry->exists($resource)) throw new \Exception(sprintf("The resource: %s doesnt exist", (string)$resource));

		$this->globalRegistry->save($role, $resource, $permission, $status);

		return;
	}

	/**
	 * Change the status option of an assigned permission to false
	 *
	 * @param RoleInterface|string $role;
	 * @param PermissionInterface|string $permission
	 * @param ResourceInterface|string $resource
	 * @return void
	 */
	public function deny($role, $permission, $resource)
	{
		$this->allow($role, $permission, $resource, false);

		return;
	}

	/**
	 * Retrieve the status of a permission assigned to a role
	 *
	 * @param RoleInterface|string $role;
	 * @param PermissionInterface|string $permission
	 * @param ResourceInterface|string $resource
	 * @return boolean
	 */
	public function getPermissionStatus($role, $permission, $resource)
	{
		if (!$this->roleRegistry->exists($role)) throw new \Exception(sprintf("The role: %s doesnt exist", (string)$role));
		if (!$this->permissionRegistry->exists($permission)) throw new \Exception(sprintf("The permission: %s doesnt exist", (string)$permission));
		if (!$this->resourceRegistry->exists($resource)) throw new \Exception(sprintf("The resource: %s doesnt exist", (string)$resource));

		$role = $this->globalRegistry->get($role);

		return $role[$resource][$permission]["status"];
	}
}