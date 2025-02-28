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

    public static function collection($orders, $pager = null): array
    {
        if ($pager instanceof \CodeIgniter\Pager\Pager) {
            return [
                'dados' => array_map(fn($order) => self::toArray($order), $orders),
                'paginacao' => [
                    'pagina_atual'  => $pager->getCurrentPage(),
                    'por_pagina'    => $pager->getPerPage(),
                    'total'         => $pager->getTotal(),
                    'ultima_pagina' => $pager->getPageCount(),
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
    
        return [
            'dados' => [],
            'paginacao' => [
                'pagina_atual'  => 1,
                'por_pagina'    => 0,
                'total'         => 0,
                'ultima_pagina' => 1,
            ]
        ];
    }
}