<?php
namespace App\Resources;

use CodeIgniter\Pager\Pager;

class OrderResource
{
    public static function toArray($order): array
    {
        if (is_object($order)) {
            $order = (array) $order;
        }

        return [
            'id'         => $order['id'] ?? null,
            'client_id'  => $order['client_id'] ?? null,
            'product_id' => $order['product_id'] ?? null,
            'quantity'   => (int) ($order['quantity'] ?? 0),
            'status'     => $order['status'] ?? 'pending',
            'created_at' => $order['created_at'] ?? date('Y-m-d H:i:s'),
            'updated_at' => $order['updated_at'] ?? date('Y-m-d H:i:s'),
        ];
    }

    public static function collection($orders): array
    {
        if ($orders instanceof Pager) {
            return [
                'data' => array_map(fn($order) => self::toArray($order), $orders->getData()),
                'pagination' => [
                    'current_page'  => $orders->getCurrentPage(),
                    'per_page'    => $orders->getPerPage(),
                    'total'         => $orders->getTotal(),
                    'last_page' => $orders->getLastPage(),
                ]
            ];
        }

        if (is_array($orders)) {
            return [
                'data' => array_map(fn($order) => self::toArray($order), $orders),
                'pagination' => [
                    'current_page'  => 1, 
                    'per_page'    => count($orders),
                    'total'         => count($orders),
                    'last_page' => 1,
                ]
            ];
        }

    }
}