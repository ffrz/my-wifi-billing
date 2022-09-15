<?php

namespace App\Controllers;

use stdClass;

class DashboardController extends BaseController
{
    public function index()
    {
        $month_names = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $data = new stdClass;
        $data->activeCustomer = $this->db->query('
            select count(0) as count from customers
            where company_id= ' . current_user()->company_id . ' 
            and status=1
        ')->getRowObject()->count;

        $data->activeProduct = $this->db->query('
            select count(0) as count from products
            where company_id= ' . current_user()->company_id . ' 
            and active=1
        ')->getRowObject()->count;

        $data->unpaidBill = $this->db->query('
            select ifnull(sum(amount), 0) as total from bills
            where company_id= ' . current_user()->company_id . ' 
            and status=0
        ')->getRowObject()->total;

        $data->unpaidBillCount = $this->db->query('
        select ifnull(count(0), 0) as total from bills
        where company_id= ' . current_user()->company_id . ' 
        and status=0
        ')->getRowObject()->total;

        $data->paidBill = $this->db->query('
            select ifnull(sum(amount), 0) as total from bills
            where company_id= ' . current_user()->company_id . ' 
            and status=1
            and year(date)=' . date('Y') . '
            and month(date)=' . date('m') . '
        ')->getRowObject()->total;

        $data->incomes = [];
        $data->incomes["months"] = [];
        $data->incomes["incomes"] = [];
        for ($i = 1; $i <= 12; $i++) {
            $data->incomes["months"][] = $month_names[$i-1];
            $data->incomes["incomes"][] = $this->db->query('
                select ifnull(sum(amount), 0) as total from bills
                where company_id= ' . current_user()->company_id . ' 
                and status=1
                and year(date_complete)=' . date('Y') . '
                and month(date_complete)=' . $i . '
            ')->getRowObject()->total;
        }
        

        return view('dashboard', [
            'data' => $data
        ]);
    }
}
