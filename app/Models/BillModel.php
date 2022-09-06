<?php

namespace App\Models;

use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table      = 'bills';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Bill::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['date', 'customer_id', 'product_id', 'total', 'due_date', 'description'];

}