<?php
/**
 * Created by PhpStorm.
 * User: fiqy_
 * Date: 5/28/2018
 * Time: 12:20 AM
 */

namespace App\Support;


class Role
{
    const ROOT = 'root';

    const STAFF_FOTO = 'staff foto';

    const STAFF_VIDEO = 'staff video';

    const STAFF_DESAIN = 'staff desain';

    const ALL = [
        Role::STAFF_DESAIN,
        Role::STAFF_VIDEO,
        Role::STAFF_FOTO,
        Role::ROOT
    ];

    /**
     * check whether the role is exist or not
     * @param $role_name
     * @param null $delimitter
     * @return bool
     */
    public static function check($role_name, $delimitter = null)
    {
        if (is_null($delimitter)) {
            if (in_array($role_name, Role::ALL)) {
                return true;
            }
        }

        return false;
    }
}