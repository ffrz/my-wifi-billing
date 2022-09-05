<?php

namespace App\Models;

use App\Entities\Customer;
use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Customer::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['username', 'password', 'status', 'fullname', 'email', 'address', 'wa', 'phone',
        'installation_date', 'id_card_number', 'map_location', 'notes'];

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

    public function getAll()
    {
        return $this->db->query('
            select c.*
                from customers c
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