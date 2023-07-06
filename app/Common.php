<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter4.github.io/CodeIgniter4/
 */

define('APP_NAME', 'WifiKu Billing');
define('APP_VERSION', 0x010000);
define('APP_VERSION_STR', '1.0.1');

define('MAX_USER_GROUP', 2);
define('MAX_USER', 5);
define('MAX_COST_CATEGORY', 10);