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
    protected $allowedFields    = ['username', 'password', 'status', 'fullname', 'email', 'address', 'wa', 'phone',
        'installation_date', 'id_card_number', 'map_location', 'notes', 'product_id', 'product_price',
        'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'
    ];

    /**
     * Periksa duplikat rekaman berdasarkan username dan id
     * @var $username nama pengguna
     * @var $id id pengguna
     * @return bool true jika ada duplikat, false jika tidak ada duplikat 
     */
    public function exists($username, $id)
    {
        $sql = 'select count(0) as count from customers where username = :username:';
        $params = ['username' => $username];

        if ($id) {
            $sql .= ' and id <> :id:';
            $params['id'] = $id;
        }

        return $this->db->query($sql, $params)->getRow()->count != 0;
    }

    public function getAllWithFilter($filter)
    {
        $where = [];
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
            order by c.username asc
        ")->getResultObject();
    }

    public function getAll()
    {
        return $this->db->query('
            select c.*
                from customers c
                order by c.username asc'
            )->getResultObject();
    }

    public function getAllActive()
    {
        return $this->db->query('
            select c.*
                from customers c where status=1
                order by c.username asc'
            )->getResultObject();
    }

    /**
     * @return \stdClass
     */
    public function findByUsername($username)
    {
        $data = $this->db->query('select * from customers where username=:username:', ['username' => $username])->getResultObject();
        if (empty($data)) {
            return null;
        }
        return $data[0];

    }

}