<?php

namespace Domain\Base\Controllers\Traits;

use Illuminate\Http\Request;

trait AllTrait
{
    /**
     * Get all :item.
     *
     * @return  \Illuminate\Pagination\LengthAwarePaginator
     * @return  \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $request = app()->make(Request::class);
        $orders = [];
        $limit = 0;
        //$page = 1;
        if ($request->has('_orders') and is_array($request->get('_orders'))) {
            $orders = $request->get('_orders');
        }

        if ($request->has('_limit')) {
            $limit = $request->get('_limit');
        }

        if ($request->has('_columns')) {
            $this->setColumns($request->get('_columns'));
            if (!is_array($this->getColumns())) {
                $this->setColumns(explode(',', $this->getColumns()));
            }
        }

        if ($request->has('_with')) {
            $this->setWith($request->get('_with'));
            if (!is_array($this->getWith())) {
                $this->setWith(explode(',', $this->getWith()));
            }
        }

        $repo = $this->getRepo();
        $trash = null;
        if ($request->has('_trash')) {
            $trash = $request->get('_trash');
        }
        switch ($trash) {
            case 'only':
                $repo = $repo->onlyTrashed();
                break;
            case 'with':
                $repo = $repo->withTrashed();
                break;

            default:
                # code...
                break;
        }

        return handleResponses($repo->all($this->getColumns(), $this->getWith(), $orders, $limit));
    }
}
