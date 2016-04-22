<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Transformers\Api;

use App\Transformers\Transformer;

class ProductsApiTransformer extends Transformer
{
    /**
     * @param $item
     *
     * @return mixed
     */
    public function transform($item)
    {
        return [
            'slug'        => $item['slug'],
            'name'        => $item['name'],
            'price'       => $item['price'],
            'description' => $item['description'],
            'payed'       => $item['payed'] === '1' ? true : false,
        ];
    }
}