<?php

namespace App\Models;

use CodeIgniter\Model;

class CostModel extends Model
{
    protected $table      = 'costs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Cost::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'description', 'category_id', 'amount', 'company_id', 'date',
        'created_at', 'created_by', 'updated_at', 'updated_by'
    ];

    public function getAll()
    {
        return $this->db->query('
            select c.*, cc.name category_name
            from costs c
            left join cost_categories cc on cc.id = c.category_id
            where c.company_id=' . current_user()->company_id . '
            order by c.date asc, c.id asc'
        )->getResultObject();
    }
}
