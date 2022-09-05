<?php

namespace App\Models;

use CodeIgniter\Model;

class UserGroupModel extends Model
{
    protected $table      = 'user_groups';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\UserGroup::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name', 'description'];

    /**
     * Periksa duplikat rekaman berdasarkan name dan id
     * @var $name nama pengguna
     * @var $id id pengguna
     * @return bool true jika ada duplikat, false jika tidak ada duplikat 
     */
    public function exists($name, $id)
    {
        $sql = 'select count(0) as count from user_groups where name = :name:';
        $params = ['name' => $name];

        if ($id) {
            $sql .= ' and id <> :id:';
            $params['id'] = $id;
        }

        return $this->db->query($sql, $params)->getRow()->count != 0;
    }

    public function getAll()
    {
        return $this->db->query('select * from user_groups order by name asc')
            ->getResultObject();
    }

}