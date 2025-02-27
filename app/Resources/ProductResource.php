<?php

namespace App\Resources;

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

    public static function collection(array $products): array
    {
        return array_map(fn($product) => self::toArray($product), $products);
    }
}
