<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table      = 'companies';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Company::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name'];

    public function getAll()
    {
        return $this->db->query('
            select c.*
                from companies c
                order by c.name asc'
            )->getResultObject();
    }

}