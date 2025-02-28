<?php
namespace App\Resources;

use CodeIgniter\Pager\Pager;

class ProductResource
{
    public static function toArray($product): array
    {
        if (is_object($product)) {
            $product = (array) $product;
        }

        return [
            'id'                => $product['id'] ?? null,
            'cliente_id_criador' => $product['client_id_creator'] ?? null,
            'preco'             => $product['price'] ?? null,
            'nome'              => $product['name'] ?? null,
            'descricao'       => $product['description'] ?? null,
            'criado_em'        => $product['created_at'] ?? date('Y-m-d H:i:s'),
            'atualizado_em'        => $product['updated_at'] ?? date('Y-m-d H:i:s'),
        ];
    }

    public static function collection($products): array
    {
        if ($products instanceof Pager) {
            return [
                'dados' => array_map(fn($product) => self::toArray($product), $products->getData()),
                'paginacao' => [
                    'pagina_atual'  => $products->getCurrentPage(),
                    'por_pagina'    => $products->getPerPage(),
                    'total'         => $products->getTotal(),
                    'ultima_pagina' => $products->getLastPage(),
                ]
            ];
        }

        if (is_array($products)) {
            return [
                'dados' => array_map(fn($product) => self::toArray($product), $products),
                'paginacao' => [
                    'pagina_atual'  => 1, 
                    'por_pagina'    => count($products),
                    'total'         => count($products),
                    'ultima_pagina' => 1,
                ]
            ];
        }

    }
}