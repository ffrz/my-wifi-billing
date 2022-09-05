<?php

namespace App\Entities;

class Acl
{
    const CHANGE_SYSTEM_SETTINGS = '001';

    const VIEW_USER_GROUPS  = '011';
    const VIEW_USER_GROUP   = '012';
    const ADD_USER_GROUP    = '013';
    const EDIT_USER_GROUP   = '014';
    const DELETE_USER_GROUP = '015';

    const VIEW_USERS  = '021';
    const VIEW_USER   = '022';
    const ADD_USER    = '023';
    const EDIT_USER   = '024';
    const DELETE_USER = '025';

    const VIEW_REPORTS = '901';

    protected static $_resources = [
        self::CHANGE_SYSTEM_SETTINGS,

        self::VIEW_USER_GROUPS,
        self::VIEW_USER_GROUP,
        self::ADD_USER_GROUP,
        self::EDIT_USER_GROUP,
        self::DELETE_USER_GROUP,

        self::VIEW_USERS,
        self::VIEW_USER,
        self::ADD_USER,
        self::EDIT_USER,
        self::DELETE_USER,

        self::VIEW_REPORTS,
    ];

    /**
     * @return array
     */
    public static function getResources()
    {
        return static::$_resources;
    }

    /**
     * @return array
     */
    public static function createResources()
    {
        $result = [];
        foreach (static::$_resources as $resource) {
            $result[$resource] = 0;
        }
        return $result;
    }
}