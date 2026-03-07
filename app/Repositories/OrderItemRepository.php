<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository extends BaseRepository
{
    protected $model = OrderItem::class;

    /**
     * Get all items for an order (raw rows for admin detail).
     */
    public function getByOrderId($orderId)
    {
        $sql = "SELECT oi.*, p.name as product_name, pv.sku 
                FROM {$this->table} oi 
                LEFT JOIN product_variants pv ON pv.id = oi.product_variant_id 
                LEFT JOIN products p ON p.id = pv.product_id 
                WHERE oi.order_id = :order_id 
                ORDER BY oi.id";
        return $this->db->fetchAll($sql, ['order_id' => $orderId]);
    }
}
