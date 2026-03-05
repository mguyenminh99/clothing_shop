<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository extends BaseRepository
{
    protected $model = Order::class;

    /**
     * Create order without updated_at (orders table may not have it).
     */
    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $id = $this->db->insert($this->table, $data);
        return $id ? $this->findById($id) : null;
    }
}
