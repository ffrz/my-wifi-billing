<?php

namespace App\Models;

use CodeIgniter\Model;

class CostCategoryModel extends Model
{
    protected $table      = 'cost_categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\CostCategory::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name', 'company_id'];

    public function getAll()
    {
        return $this->db->query('
            select c.*
                from cost_categories c
                where c.company_id=' . current_user()->company_id . '
                order by c.name asc'
            )->getResultObject();
    }

    public function exists($name, $id)
    {
        $sql = 'select count(0) as count
            from cost_categories c
            where name=:name:
            and c.company_id=' . current_user()->company_id;
        $params = ['name' => $name];
        if ($id) {
            $sql .= ' and id <> :id:';
            $params['id'] = $id;
        }

        return $this->db->query($sql, $params)->getRow()->count != 0;
    }
}