<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Customer::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['cid', 'password', 'status', 'fullname', 'email', 'address', 'wa', 'phone',
        'installation_date', 'id_card_number', 'map_location', 'notes', 'product_id', 'product_price',
        'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by',
        'company_id'
    ];

    public function getAllWithFilter($filter)
    {
        $where = [];
        $where[] = 'c.company_id='.current_user()->company_id;
        if ($filter->status != 'all') {
            $where[] = 'c.status=' . (int)$filter->status;
        }

        if (!empty($where)) {
            $where = ' where ' . implode(' and ', $where);
        }
        else {
            $where = '';
        }

        return $this->db->query("
        select c.*, p.name product_name
            from customers c
            left join products p on p.id = c.product_id
            $where
            order by c.cid asc
        ")->getResultObject();
    }

    public function getAll()
    {
        return $this->db->query('
            select c.*
                from customers c
                where company_id=' . current_user()->company_id . '
                order by c.cid asc'
            )->getResultObject();
    }

    public function getAllActive()
    {
        return $this->db->query('
            select c.*
                from customers c
                where
                company_id=' . current_user()->company_id . '
                and status=1
                order by c.cid asc'
            )->getResultObject();
    }

    /**
     * @return \stdClass
     */
    public function findByCustomerId($cid)
    {
        $data = $this->db->query('
            select * from customers
            where
            company_id=' . current_user()->company_id . '
            and cid=:cid:', ['cid' => $cid])->getResultObject();
        if (empty($data)) {
            return null;
        }
        return $data[0];

    }

}