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
    const CEO = 'ceo';
    const CTO = 'cto';
    const ADMIN = 'admin';
    const COO = 'coo';
    const PHOTOGRAPHER = 'photographer';
    const VIDEOGRAPHER = 'videographer';
    const DESIGNER = 'designer';

    const ALL = [
        Role::DESIGNER,
        Role::VIDEOGRAPHER,
        Role::PHOTOGRAPHER,
        Role::COO,
        Role::ADMIN,
        Role::CTO,
        Role::CEO,
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