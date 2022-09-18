<?php

namespace App\Entities;

class Acl
{
    const CHANGE_SYSTEM_SETTINGS = '001';

    const VIEW_USERS = '101';
    const ADD_USER = '102';
    const EDIT_USER = '103';
    const DELETE_USER = '104';

    const VIEW_USER_GROUPS = '121';
    const ADD_USER_GROUP = '122';
    const EDIT_USER_GROUP = '123';
    const DELETE_USER_GROUP = '124';

    const VIEW_BILLS = '501';
    const GENERATE_BILLS = '502';
    const VIEW_BILL = '503';
    const ADD_BILL = '504';
    const EDIT_BILL = '505';
    const DELETE_BILL = '506';
    const COMPLETE_BILL = '507';
    const CANCEL_BILL = '508';    

    const VIEW_CUSTOMERS = '401';
    const ADD_CUSTOMER = '402';
    const EDIT_CUSTOMER = '403';
    const DELETE_CUSTOMER = '404';
    const VIEW_CUSTOMER = '405';
    const CHANGE_CUSTOMER_PRODUCT = '406';

    const VIEW_PRODUCTS = '301';
    const ADD_PRODUCT = '302';
    const EDIT_PRODUCT = '303';
    const DELETE_PRODUCT = '304';

    const VIEW_COSTS = '201';
    const ADD_COST = '202';
    const EDIT_COST = '203';
    const DELETE_COST = '204';

    const VIEW_COST_CATEGORIES = '211';
    const ADD_COST_CATEGORY = '212';
    const EDIT_COST_CATEGORY = '213';
    const DELETE_COST_CATEGORY = '214';

    const VIEW_REPORTS = '901';

    protected static $_resources = [
        self::VIEW_BILLS,
        self::GENERATE_BILLS,
        self::VIEW_BILL,
        self::ADD_BILL,
        self::EDIT_BILL,
        self::DELETE_BILL,
        self::COMPLETE_BILL,
        self::CANCEL_BILL,

        self::VIEW_CUSTOMERS,
        self::ADD_CUSTOMER,
        self::EDIT_CUSTOMER,
        self::DELETE_CUSTOMER,
        self::VIEW_CUSTOMER,
        self::CHANGE_CUSTOMER_PRODUCT,

        self::VIEW_PRODUCTS,
        self::ADD_PRODUCT,
        self::EDIT_PRODUCT,
        self::DELETE_PRODUCT,

        self::VIEW_COSTS,
        self::ADD_COST,
        self::EDIT_COST,
        self::DELETE_COST,

        self::VIEW_COST_CATEGORIES,
        self::ADD_COST_CATEGORY,
        self::EDIT_COST_CATEGORY,
        self::DELETE_COST_CATEGORY,

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