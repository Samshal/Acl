# Acl [![Build Status](https://travis-ci.org/Samshal/Acl.svg?branch=master)](https://travis-ci.org/Samshal/Acl) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Samshal/Acl/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Samshal/Acl/?branch=master)

Samshal\Acl adds a role based permission system for user authentication. In general, it provides a lightweight access control list for privileges and permission management.

### Why you might need it

Access Control Lists allow an application to control access to its areas, they provide a flexible interface for creating Permissions, Roles, Resources and assigning the created permissions on roles based restricting/granting access to resources.

This component is an implementation of an ACL, it makes it easy for you to get up and running with user authorization.

### Class Features
- Creation of Resources, Roles and Permissions
- Ability to set Permissions on Resources and granting these Permissions to Roles.
- Fully Serializable, can work interoperably with any source of data.
- Compatible with PHP v7.0+
- Easy to use

**Resources** are objects which acts in accordance to the permissions defined on them by the ACLs. **Roles** are objects that requests access to resources and can be allowed or denied by the ACL layers. **Permissions** are just rules defined on Resources.

### Metrics of master branch

![Package Metrics](https://raw.githubusercontent.com/Samshal/Acl/master/phpmetric_maintainability.png)

### License
This software is distributed under the [MIT](https://opensource.org/licenses/MIT) license. Please read LICENSE for information on the software availability and distribution.

### Installation
Samshal\Acl is available via [Composer/Packagist](https://packagist.org/packages/samshal/acl), so just add this line to your `composer.json` file:
```json
	{
		"require":{
			"samshal/scripd":"^1.0"
		}
	}
```
or
```shell
	composer require samshal/acl
```
