<?php

namespace App\Resources;

class OrderResource
{
    public static function toArray(array $order): array
    {
        if (is_object($order)) {
            $order = (array) $order;
        }

        return [
            'id'         => $order['id'] ?? null,
            'client_id'  => $order['client_id'],
            'product_id' => $order['product_id'],
            'quantity'   => (int) $order['quantity'],
            'status'     => $order['status'] ?? 'pending',
            'created_at' => $order['created_at'] ?? date('Y-m-d H:i:s'),
            'updated_at' => $order['updated_at'] ?? date('Y-m-d H:i:s'),
        ];
    }

    public static function collection(array $orders): array
    {
        return array_map(fn($order) => self::toArray($order), $orders);
    }
}
