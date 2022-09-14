<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductActivationModel extends Model
{
    protected $table      = 'product_activations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\ProductActivation::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['customer_id', 'product_id', 'date', 'price', 'bill_period', 'company_id'];
}