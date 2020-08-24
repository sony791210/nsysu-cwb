<?php

namespace App\Traits;

Trait ArrayHelper
{
    /**
     *  重新整理Items, 去除key
     * @param $detail
     * @return string
     */
    public function remap($items)
    {
        if (!$items) return [];

        foreach ($items as $item) {
            $newItems[] = $item;
        }

        return $newItems;
    }
}
