<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Product::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name', 'description', 'active', 'price', 'bill_period', 'nottify_before',
        'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by',
        'company_id'
    ];

    /**
     * Periksa duplikat rekaman berdasarkan nama paket dan id
     * @var $name nama produk
     * @var $id id produk
     * @return bool true jika ada duplikat, false jika tidak ada duplikat 
     */
    public function exists($name, $id)
    {
        $sql = 'select count(0) as count from products where name = :name:';
        $params = ['name' => $name];

        if ($id) {
            $sql .= ' and id <> :id:';
            $params['id'] = $id;
        }

        return $this->db->query($sql, $params)->getRow()->count != 0;
    }

    /**
     * Get all products
     * @return Array
     */
    public function getAllActive()
    {
        return $this->db->query('
            select c.*
                from products c
                where active=1
                order by c.name asc'
            )->getResultObject();
    }

    /**
     * @return \stdClass
     */
    public function findByName($name)
    {
        $data = $this->db->query('select * from products where name=:name:', ['name' => $name])->getResultObject();
        if (empty($data)) {
            return null;
        }

        return $data[0];

    }

}