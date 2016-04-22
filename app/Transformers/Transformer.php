<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/17/16
 */

namespace App\Transformers;

abstract class Transformer
{
    /**
     * Transform a collection of items.
     *
     * @param array $items
     *
     * @return array
     */
    public function transformCollection($items)
    {
        $transformedItems = [];
        foreach ($items as $item) {
            $transformedItems[] = $this->transform($item);
        }

        return $transformedItems;
    }

    /**
     * @param $item
     *
     * @return mixed
     */
    public abstract function transform($item);
}