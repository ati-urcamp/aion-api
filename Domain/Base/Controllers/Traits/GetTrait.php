<?php

namespace Domain\Base\Controllers\Traits;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait GetTrait
{
    /**
     * Get :item by id :id.
     *
     * @param  int $id
     *
     * @return Model
     */
    public function show(int $id)
    {
        $request = app()->make(Request::class);
        if ($request->has('_columns')) {
            $this->columns = $request->get('_columns');
            if (!is_array($this->columns)) {
                $this->columns = explode(',', $this->columns);
            }
        }

        if ($request->has('_with')) {
            $this->with = $request->get('_with');
            if (!is_array($this->with)) {
                $this->with = explode(',', $this->with);
            }
        }

        $repo = $this->repo;
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

        return handleResponses($repo->get($id, $this->columns, $this->with, $this->load));
    }
}
