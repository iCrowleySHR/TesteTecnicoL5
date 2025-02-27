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
                'pagination' => [
                    'current_page'  => $products->getCurrentPage(),
                    'per_page'    => $products->getPerPage(),
                    'total'         => $products->getTotal(),
                    'last_page' => $products->getLastPage(),
                ]
            ];
        }

        if (is_array($products)) {
            return [
                'data' => array_map(fn($product) => self::toArray($product), $products),
                'pagination' => [
                    'current_page'  => 1, 
                    'per_page'    => count($products),
                    'total'         => count($products),
                    'last_page' => 1,
                ]
            ];
        }

    }
}