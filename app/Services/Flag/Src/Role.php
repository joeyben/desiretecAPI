<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 28.01.19
 * Time: 17:30.
 */

namespace App\Services\Flag\Src;

/**
 * Class Role.
 */
class Role
{
    const PERMISSIONS = [
        ['name' => 'View Backend'],
        ['name' => 'View Frontend'],
        ['name' => 'View Access Management'],
        ['name' => 'View User Management'],
        ['name' => 'View Active User'],
        ['name' => 'View Deleted User'],
        ['name' => 'View Deactive User'],
        ['name' => 'Show User Details'],
        ['name' => 'Create User'],
        ['name' => 'Delete User'],
        ['name' => 'Update User'],
        ['name' => 'Logs User'],
        ['name' => 'Activate User'],
        ['name' => 'Deactivate User'],
        ['name' => 'Login As User'],
        ['name' => 'Clear User Session'],
        ['name' => 'View Role Management'],
        ['name' => 'Create Role'],
        ['name' => 'Edit Role'],
        ['name' => 'Update Role'],
        ['name' => 'Delete Role'],
        ['name' => 'Logs Role'],
        ['name' => 'View Permission Management'],
        ['name' => 'Read Permission'],
        ['name' => 'Create Permission'],
        ['name' => 'Update Permission'],
        ['name' => 'Delete Permission'],
        ['name' => 'Logs Permission'],
        ['name' => 'View Permission'],
        ['name' => 'View Page'],
        ['name' => 'Create Page'],
        ['name' => 'Delete Page'],
        ['name' => 'Edit Page'],
        ['name' => 'View Email Templates'],
        ['name' => 'Create Email Templates'],
        ['name' => 'Edit Email Templates'],
        ['name' => 'Delete Email Templates'],
        ['name' => 'Edit Settings'],
        ['name' => 'View FAQ Management'],
        ['name' => 'Create FAQ'],
        ['name' => 'Edit FAQ'],
        ['name' => 'Delete FAQ'],
        ['name' => 'View Wishes'],
        ['name' => 'View Wish'],
        ['name' => 'Read Wish'],
        ['name' => 'Update Wish'],
        ['name' => 'Logs Wish'],
        ['name' => 'Restore Wish'],
        ['name' => 'Create Wish'],
        ['name' => 'Edit Wish'],
        ['name' => 'Delete Wish'],
        ['name' => 'View Wishes list'],
        ['name' => 'View Wish Frontend'],
        ['name' => 'View Whitelabels'],
        ['name' => 'Create Whitelabel'],
        ['name' => 'Edit Whitelabel'],
        ['name' => 'Delete Whitelabel'],
        ['name' => 'View Offers'],
        ['name' => 'Create Offer'],
        ['name' => 'Edit Offer'],
        ['name' => 'Delete Offer'],
        ['name' => 'View Comments'],
        ['name' => 'Create Comment'],
        ['name' => 'Edit Comment'],
        ['name' => 'Delete Comment'],
        ['name' => 'View Comments frontend'],
        ['name' => 'View Groups'],
        ['name' => 'Read Group'],
        ['name' => 'View Group'],
        ['name' => 'Update Group'],
        ['name' => 'Logs Group'],
        ['name' => 'Create Group'],
        ['name' => 'Edit Group'],
        ['name' => 'Delete Group'],
        ['name' => 'Create Distribution'],
        ['name' => 'Edit Distribution'],
        ['name' => 'Delete Distribution'],
        ['name' => 'Create Agent'],
        ['name' => 'Edit Agent'],
        ['name' => 'Delete Agent'],
        ['name' => 'View Agent'],
        ['name' => 'View Category'],
        ['name' => 'Create Category'],
        ['name' => 'Read Category'],
        ['name' => 'Update Category'],
        ['name' => 'Delete Category'],
        ['name' => 'Restore Category'],
        ['name' => 'Logs Category'],
        ['name' => 'View Dashboard'],
        ['name' => 'Edit User'],
        ['name' => 'View Agent Frontend'],
    ];
}
