<?php

declare(strict_types=1);
/**
 * @license MIT
 * @author Samuel Adeshina <samueladeshina73@gmail.com>
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
	 *  @var array $sesion
	 */
	protected $session = [];

	/**
	 * @var SYN_ALLOW
	 */
	const SYN_ALLOW = "can";
	/**
	 * @var SYN_ALLOW
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
	 */
	protected function initRegistries()
	{
		$this->roleRegistry = new RoleRegistry();
		$this->resourceRegistry = new ResourceRegistry();
		$this->permissionRegistry = new PermissionRegistry();
		$this->globalRegistry = new GlobalRegistry();
	}

	/**
	 * Initializes the session
	 */
	protected function initSession()
	{
		$this->session["query"] = true;
		unset($this->session["role"], $this->session["status"]);
	}

	/**
	 * 
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
	 * 
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
	}

	/**
	 * Adds a new role object to the registry
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
	}

	/**
	 * Adds a new resource object to the registry
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
	}

	/**
	 * Adds a new permission object to the registry
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
	}

	/**
	 * 
	 */
	public function add($object)
	{
		if (in_array(__NAMESPACE__."\\Role\\RoleInterface", class_implements($object)))
		{
			$this->addRole($object);
		}
		else if (in_array(__NAMESPACE__."\\Resource\\ResourceInterface", class_implements($object)))
		{
			$this->addResource($object);
		}
		else if (in_array(__NAMESPACE__."\\Permission\\PermissionInterface", class_implements($object)))
		{
			$this->addPermission($object);
		}
	}

	/**
	 * 
	 */
	public function allow($role, $permission, $resource, $status=true)
	{
		if (!$this->roleRegistry->exists($role)) throw new \Exception(sprintf("The role: %s doesnt exist", (string)$role));
		if (!$this->permissionRegistry->exists($permission)) throw new \Exception(sprintf("The permission: %s doesnt exist", (string)$permission));
		if (!$this->resourceRegistry->exists($resource)) throw new \Exception(sprintf("The resource: %s doesnt exist", (string)$resource));

		$this->globalRegistry->save($role, $resource, $permission, $status);
	}

	/**
	 * 
	 */
	public function deny($role, $permission, $resource)
	{
		$this->allow($role, $permission, $resource, false);
	}

	/**
	 * 
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