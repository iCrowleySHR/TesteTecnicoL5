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
            'cliente_id'  => $order['client_id'] ?? null,
            'produto_id' => $order['product_id'] ?? null,
            'quantidade'   => (int) ($order['quantity'] ?? 0),
            'status'     => $order['status'] ?? 'não informado',
            'criado_em' => $order['created_at'] ?? date('Y-m-d H:i:s'),
            'atualizado_em' => $order['updated_at'] ?? date('Y-m-d H:i:s'),
        ];
    }

    public static function collection($orders): array
    {
        if ($orders instanceof Pager) {
            return [
                'dados' => array_map(fn($order) => self::toArray($order), $orders->getData()),
                'paginacao' => [
                    'pagina_atual'  => $orders->getCurrentPage(),
                    'por_pagina'    => $orders->getPerPage(),
                    'total'         => $orders->getTotal(),
                    'ultima_pagina' => $orders->getLastPage(),
                ]
            ];
        }

        if (is_array($orders)) {
            return [
                'dados' => array_map(fn($order) => self::toArray($order), $orders),
                'paginacao' => [
                    'pagina_atual'  => 1, 
                    'por_pagina'    => count($orders),
                    'total'         => count($orders),
                    'ultima_pagina' => 1,
                ]
            ];
        }

    }
}