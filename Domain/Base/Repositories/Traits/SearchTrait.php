<?php

namespace Domain\Base\Repositories\Traits;

use Domain\Base\Repositories\Criteria\Search;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait SearchTrait
{
    /**
     * Prepare Search.
     *
     * @param  array  $data
     * @param  array  $options
     * @return LengthAwarePaginator|Collection
     *
     * @throw Exception
     */
    public function prepareSearch(array $data, array $options = [])
    {
        $model = $this->model;
        $search = app()->make(Search::class);
        $search->run($model, $data);

        $model = $search->getQuery();
        if (isset($options['_trash'])) {
            if ($options['_trash'] == 'only') {
                $model->onlyTrashed();
            }
            if ($options['_trash'] == 'with') {
                $model->withTrashed();
            }
        }

        $options['_limit'] = $options['_limit'] ?? 20;
        $options['_columns'] = $options['_columns'] ?? ['*'];

        if (isset($options['_with'])) {
            $model->with($options['_with']);
        }

        $orderBy = null;
        if (isset($data['orderBy'])) {
            $orderBy = $data['orderBy'];
        }
        $model = $this->orderByFields($model, $orderBy);

        return $model;
    }

    /**
     * Search.
     *
     * @param  array  $data
     * @param  array  $options
     * @return LengthAwarePaginator|Collection
     *
     * @throw Exception
     */
    public function doSearch(array $data, array $options = [])
    {
        $model = $this->prepareSearch($data, $options);

        // Getting options for paginator
        $limit = isset($options['_limit']) && $options['_limit'] === 'all' ? null : ($options['_limit'] ?? 20);
        $columns = $options['_columns'] ?? ['*'];

        if (!$limit) {
            return $model->get($columns);
        }

        return $model->paginate($limit, $columns, '_page');
    }
}
