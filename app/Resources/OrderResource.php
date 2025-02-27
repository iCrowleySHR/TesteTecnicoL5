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
                'paginacao' => [
                    'pagina_atual'  => $orders->getCurrentPage(),
                    'por_pagina'    => $orders->getPerPage(),
                    'total'         => $orders->getTotal(),
                    'ultima_pagina' => $orders->getLastPage(),
                ]
            ];
        }

        // Se for um array simples
        if (is_array($orders)) {
            return [
                'data' => array_map(fn($order) => self::toArray($order), $orders),
                'paginacao' => [
                    'pagina_atual'  => 1, 
                    'por_pagina'    => count($orders),
                    'total'         => count($orders),
                    'ultima_pagina' => 1,
                ]
            ];
        }

        throw new \InvalidArgumentException("O parâmetro deve ser um array ou um objeto de paginação do CodeIgniter.");
    }
}