<?php

namespace Domain\Base\Repositories\Traits;

use Illuminate\Database\Eloquent\Builder;

trait OrderByTrait
{
    /**
     * @param $query Builder
     * @param array|null $orders
     * @return Builder
     */
    public function orderByFields($query, $orders = null)
    {
        if (isset($orders) && is_array($orders) && count($orders)) {
            foreach ($orders as $order) {
                $query = $query->orderBy($order['column'], $order['direction'] ?? 'ASC');
            }
        }
        return $query;
    }
}
