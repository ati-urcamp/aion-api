<?php

namespace Domain\Base\Repositories\Traits;

use Exception;
use Log;

trait GetsTrait
{

    /**
     * Get all item of model.
     *
     * @param array $columns
     * @param array $with
     * @param array $orders
     * @param int $limit
     * @param int|null $page
     * @return mixed
     */
    public function all(array $columns = ['*'], array $with = [], $orders = [], $limit = 0, int $page = null)
    {
        $query = $this->model;

        if (!empty($with)) {
            $query = $query->with($with);
        }

        $query = $this->orderByFields($query, $orders);

        if ($limit === 0) {
            return $query->get($columns);
        }

        $query = $query->paginate($limit, $columns, '_page');

        return $query;
    }

    /**
     * Get item of model by id :id.
     *
     * @param int $id
     * @param array $columns
     * @param array $with
     * @param array $load
     * @return mixed
     * @throws Exception
     *
     */
    public function get(int $id, array $columns = ['*'], array $with = [], array $load = [])
    {
        try {
            $item = $this->model;
            if (!empty($with)) {
                $item = $item->with($with);
            }
            $item = $item->find($id, $columns);

            if (!empty($load) and !is_null($item)) {
                $item->load($load);
            }

            if ($item) {
                return $item;
            } else {
                throw new Exception('Item not found');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
