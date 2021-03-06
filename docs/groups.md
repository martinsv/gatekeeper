# Groups

Groups are represented as objects in the Gatekeeper system with the following properties:

- description
- name
- id
- created
- updated
- users (relational)

## Creating a Group

Making a new group is as easy as making a new user. One thing to note, the *group name* must be **unique**:

```php
<?php
$attrs = array(
    'name' => 'group1',
    'description' => 'Group #1'
);
Gatekeeper::createGroup($attrs);
?>
```

## Getting Group Users

Much like you can easily get the groups the user belongs to, you can also get the members of a group. This will return a collection of user objects:

```php
<?php
$users = Gatekeeper::findGroupById(1)->users;

foreach ($users as $user) {
    echo 'Username: '.$user->username."\n";
}
?>
```

## Checking to see if a user is in a group

You can use the `inGroup` method to check and see if a user ID is in a group:

```php
<?php
$userId = 1;
if (Gatekeeper::findGroupById(1)->inGroup($userId) === true) {
	echo 'User is in the group!';
}
?>
```

## Adding a permission to a group

You can add permissions to groups too. These are related to the groups, not the users directly, so if you get the permissions for a user, these will not show in the list.

```php
<?php
$permId = 1;
Gatekeeper::findGroupById(1)->addPermission($permId);

// Or you can use a PermissionModel object
$permission = Gatekeeper::findPermissionById(1);
Gatekeeper::findGroupById(1)->addPermission($permission);
?>
```

## Getting the permissions associated with the group

Since groups can have permissions attached, you can fetch those through the `permissions` property much in the same way you can for users:

```php
<?php
$permissions = Gatekeeper::findGroupById(1)->permissions;
foreach ($permissions as $permission) {
	echo 'Description: '.$permission->description."\n";
}
?>
```