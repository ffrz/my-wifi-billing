<?php

use \App\Entities\StockUpdate;

function current_user_can($access)
{
    $user = current_user();

    if (!$user) {
        return false;
    }

    if ($user->is_admin) {
        return true;
    }

    if (isset($user->acl[$access]) && $user->acl[$access] == 1) {
        return true;
    }

    return false;
}
/**
 * Helper function untuk merender kelas 'menu-open' pada sidebar
 * @param $self View
 * @param $name nama menu
 * @return string
 */
function menu_open($self, $name) {
    return !empty($self->menuActive) && $self->menuActive == $name ? 'menu-open' : '';
}

function menu_active($self, $name) {
    return !empty($self->menuActive) && $self->menuActive == $name ? 'active' : '';
}

function datetime_from_input($str)
{
    $input = explode(' ', $str);
    $date = explode('-', $input[0]);

    $out =  "$date[2]-$date[1]-$date[0]";
    if (count($input) == 2) {
        $out .=  " $input[1]";
    }

    return $out;
}

/**
 * Helper function untuk merender kelas 'active' pada nav-item sidebar
 * @param $self View
 * @param $name nama nav
 * @return string
 */
function nav_active($self, $name) {
    return !empty($self->navActive) && $self->navActive == $name ? 'active' : '';
}

function extract_daterange($daterange) {
    if (preg_match("/^([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])) - ([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))$/", $daterange, $matches)) {
        return [$matches[1], $matches[4]];
    }
    return false;
}

function format_number($number, int $prec = 0)
{
    return number_format($number, $prec, ',', '.');
}

function str_to_double($str)
{
    return doubleVal(str_replace('.', '', $str));
}

function str_to_int($str)
{
    return intVal(str_replace('.', '', $str));
}

function is_admin()
{
    return session()->get('current_user')->is_admin;
}

function current_user()
{
    return session()->get('current_user');
}

function format_datetime($date, $format = 'dd-MM-yyyy HH:mm:ss', $locale = null) {
    if (!$date) {
        return '?';
    }
    if (!$date instanceof DateTime) {
        $date = new DateTime($date);
    }
    return IntlDateFormatter::formatObject($date, $format, $locale);
}

function format_date($date, $format = 'dd-MM-yyyy', $locale = null) {
    if (!$date instanceof DateTime) {
        $date = new DateTime($date);
    }
    return IntlDateFormatter::formatObject($date, $format, $locale);
}

function wa_send_url($contact) {
    $contact = str_replace('-', '', $contact);
    if (substr($contact, 0, 1) == '0') {
        $contact = '62' . substr($contact, 1, strlen($contact));
    }
    if (strlen($contact) > 10) {
        return "https://web.whatsapp.com/send?phone=$contact";
    }
    return '#';
}

function wa_send($contact, $message) {
    $contact = str_replace('-', '', $contact);
    if (substr($contact, 0, 1) == '0') {
        $contact = '62' . substr($contact, 1, strlen($contact));
    }
    if (strlen($contact) > 10) {
        return "https://web.whatsapp.com/send?phone=$contact&text=$message";
    }
    return '#';
}

function format_customer_id($id)
{
    return 'P' . str_pad($id, 3, '0', STR_PAD_LEFT);
}