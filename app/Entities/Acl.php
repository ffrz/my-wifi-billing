<?php

namespace App\Entities;

class Acl
{
    const CHANGE_SYSTEM_SETTINGS = '001';
    const VIEW_BILLS = '501';
    const VIEW_CUSTOMERS = '401';
    const VIEW_PRODUCTS = '301';
    const VIEW_COSTS = '201';
    const VIEW_COST_CATEGORIES = '211';
    const VIEW_REPORTS = '901';

    protected static $_resources = [
        self::CHANGE_SYSTEM_SETTINGS,
        self::VIEW_BILLS,
        self::VIEW_CUSTOMERS,
        self::VIEW_PRODUCTS,
        self::VIEW_COSTS,
        self::VIEW_COST_CATEGORIES,
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