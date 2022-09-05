<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table      = 'settings';
    protected $primaryKey = 'key';
    protected $allowedFields = ['key', 'value'];

    public function get($key, $default = null)
    {
        $row = $this->db->query('select ifnull(`value`, "") as `value` from settings where `key`=:key:', [
            'key' => $key
        ])->getRow();
        return $row ? $row->value : $default;
    }

    public function setValue($key, $value)
    {
        $this->db->query('
            INSERT INTO
            settings (`key`, `value`)
            VALUES   (:key:, :value:)
            ON DUPLICATE KEY UPDATE
            `key`=:key:, `value`=:value:', [
                'key' => $key,
                'value' => $value,
        ]);
    }
}