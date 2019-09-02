<?php

namespace Domain\Base\Repositories\Traits;

use Exception;

trait RestoreTrait
{
    /**
     * @param $id
     * @param string $field
     * @return mixed
     * @throws Exception
     */
    public function restore($id, $field = 'id')
    {
        try {
            return $this->model->onlyTrashed()->where($field, $id)->restore();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
