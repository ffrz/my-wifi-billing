<?php

namespace App\Models;

use App\Entities\User;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\User::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['username', 'password', 'fullname', 'active', 'is_admin', 'group_id'];

    /**
     * Periksa duplikat rekaman berdasarkan username dan id
     * @var $username nama pengguna
     * @var $id id pengguna
     * @return bool true jika ada duplikat, false jika tidak ada duplikat 
     */
    public function exists($username, $id)
    {
        $sql = 'select count(0) as count from users where username = :username:';
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
            select u.*, g.name group_name
                from users u
                left join user_groups g on g.id = u.group_id
                order by u.username asc'
            )->getResultObject();
    }

    /**
     * @return \stdClass
     */
    public function findByUsername($username)
    {
        $data = $this->db->query('select * from users where username=:username:', ['username' => $username])->getResultObject();
        if (empty($data)) {
            return null;
        }
        return $data[0];

    }

}