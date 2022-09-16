<?php

namespace App\Controllers;

use App\Entities\Cost;
use CodeIgniter\Database\Exceptions\DataException;
use stdClass;

class CostController extends BaseController
{
    public function index()
    {
        $filter = new stdClass;
        $filter->year = (int)$this->request->getGet('year');
        $filter->month = $this->request->getGet('month');
        
        if ($filter->year == 0) {
            $filter->year = date('Y');
        }
        if ($filter->month == null) {
            $filter->month = date('m');
        }

        if ($filter->month < 0 || $filter->month > 12) {
            $filter->month = date('m');
        }

        $where = [];
        $where[] = 'c.company_id=' . current_user()->company_id;
        $where[] = 'year(date)=' . $filter->year;
        if ($filter->month != 0) {
            $where[] = 'month(date)=' . $filter->month;
        }

        $where = implode(' and ', $where);
        if (!empty($where)) {
            $where = ' where ' . $where;
        }

        $sql = "
            select c.*, cc.name category_name
            from costs c
            left join cost_categories cc on cc.id = c.category_id
            $where
            order by c.date asc, c.id asc";
        $items = $this->db->query($sql)->getResultObject();

        return view('cost/index', [
            'items' => $items,
            'filter' => $filter,
        ]);
    }

    public function edit($id)
    {
        $model = $this->getCostModel();
        if ($id == 0) {
            $item = new Cost();
            $item->date = date('Y-m-d');
        } else {
            $item = $model->find($id);
            if (!$item || $item->company_id != current_user()->company_id) {
                return redirect()->to(base_url('costs'))->with('warning', 'Biaya tidak ditemukan.');
            }
        }

        $errors = [];

        if ($this->request->getMethod() === 'post') {
            $item->fill($this->request->getPost());
            $item->amount = (float)$item->amount;
            $item->date = datetime_from_input($item->date);

            if (!$item->category_id) {
                $item->category_id = null;
            }

            if ($item->amount == 0.) {
                $errors['amount'] = 'Masukkan Jumlah Biaya.';
            }
            
            if (strlen($item->description) == 0) {
                $errors['description'] = 'Masukkan deskripsi.';
            }

            if (empty($errors)) {
                //try {
                if (!$item->id) {
                    $item->created_at = date('Y-m-d H:i:s');
                    $item->created_by = current_user()->username;
                    $item->company_id = current_user()->company_id;
                } else {
                    $item->updated_at = date('Y-m-d H:i:s');
                    $item->updated_by = current_user()->username;
                }
                $model->save($item);
                //} catch (DataException $ex) {
                //}
                return redirect()->to(base_url("costs"))->with('info', 'Biaya operasional telah disimpan.');
            }
        }

        return view('cost/edit', [
            'data' => $item,
            'categories' => $this->getCostCategoryModel()->getAll(),
            'errors' => $errors,
        ]);
    }

    public function delete($id)
    {
        $model = $this->getCostModel();
        $item = $model->find($id);
        if (!$item || $item->company_id != current_user()->company_id) {
            return redirect()->to(base_url('costs'))->with('warning', 'Rekaman biaya tidak ditemukan.');
        }

        $this->db->query("delete from costs where id=$item->id");

        return redirect()->to(base_url('costs'))->with('info', 'Rekaman biaya telah dihapus.');
    }
}
