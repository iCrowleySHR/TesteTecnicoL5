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
            'client_id_creator' => $product['client_id_creator'] ?? null,
            'price'             => $product['price'] ?? null,
            'name'              => $product['name'] ?? null,
            'description'       => $product['description'] ?? null,
            'created_at'        => $product['created_at'] ?? date('Y-m-d H:i:s'),
            'updated_at'        => $product['updated_at'] ?? date('Y-m-d H:i:s'),
        ];
    }

    public static function collection($products): array
    {
        if ($products instanceof Pager) {
            return [
                'data' => array_map(fn($product) => self::toArray($product), $products->getData()),
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
                'data' => array_map(fn($product) => self::toArray($product), $products),
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