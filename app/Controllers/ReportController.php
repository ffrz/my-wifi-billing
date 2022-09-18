<?php

namespace App\Controllers;

use App\Entities\Acl;
use stdClass;

class ReportController extends BaseController
{
    public function unpaidBills()
    {
        if (!current_user_can(Acl::VIEW_REPORTS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $print = $this->request->getGet('print');
        $filter = $this->initFilter();

        $date = "$filter->year-$filter->month-01";

        $where = [];
        $where[] = 'b.company_id=' . current_user()->company_id;
        $where[] = "date<='$date'";
        $where[] = 'b.status=0';

        $where = implode(' and ', $where);
        if (!empty($where)) {
            $where = ' where ' . $where;
        }

        $sql = "select
            b.*, c.fullname, c.wa, c.address, c.cid, p.name product_name
            from bills b
            inner join customers c on b.customer_id = c.id
            left join products p on b.product_id = p.id 
            $where
            order by b.date, c.fullname asc";
        $items = $this->db->query($sql)->getResultObject();

        return view('report/unpaid-bills' . ($print ? '-print' : ''), [
            'items' => $items,
            'filter' => $filter,
        ]);
    }

    public function paidBills()
    {
        if (!current_user_can(Acl::VIEW_REPORTS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $print = $this->request->getGet('print');
        $filter = $this->initFilter();

        $where = [];
        $where[] = 'b.company_id=' . current_user()->company_id;
        $where[] = 'b.status=1';
        $where[] = 'year(date_complete)=' . $filter->year;
        if ($filter->month != 0) {
            $where[] = 'month(date_complete)=' . $filter->month;
        }

        $where = implode(' and ', $where);
        if (!empty($where)) {
            $where = ' where ' . $where;
        }

        $sql = "select
            b.*, c.fullname, c.wa, c.address, c.cid, p.name product_name
            from bills b
            inner join customers c on b.customer_id = c.id
            left join products p on b.product_id = p.id 
            $where
            order by b.date_complete, b.id asc";
        $items = $this->db->query($sql)->getResultObject();

        return view('report/paid-bills' . ($print ? '-print' : ''), [
            'items' => $items,
            'filter' => $filter,
        ]);
    }

    public function cost()
    {
        if (!current_user_can(Acl::VIEW_REPORTS)) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        $print = $this->request->getGet('print');
        $filter = $this->initFilter();

        $where = [];
        $where[] = 'c.company_id=' . current_user()->company_id;
        $where[] = 'year(c.date)=' . $filter->year;
        if ($filter->month != 0) {
            $where[] = 'month(c.date)=' . $filter->month;
        }

        $where = implode(' and ', $where);
        if (!empty($where)) {
            $where = ' where ' . $where;
        }

        $sql = "select c.*, cc.name category_name
            from costs c
            left join cost_categories cc on cc.id = c.category_id
            $where
            order by c.date asc";
        $items = $this->db->query($sql)->getResultObject();

        return view('report/cost' . ($print ? '-print' : ''), [
            'items' => $items,
            'filter' => $filter,
        ]);
    }

    private function initFilter()
    {
        $filter = new stdClass;
        $filter->status = $this->request->getGet('status');
        $filter->year = (int)$this->request->getGet('year');
        $filter->month = $this->request->getGet('month');
        
        if ($filter->year == 0) {
            $filter->year = date('Y');
        }

        if ($filter->month == null) {
            $filter->month = date('m');
        }
        else {
            $filter->month = (int)$filter->month;
        }

        if ($filter->month < 0 || $filter->month > 12) {
            $filter->month = date('m');
        }

        return $filter;
    }
}
