<?php

namespace Domain\Base\Repositories\Traits;

use Exception;
use Log;

trait DeleteTrait
{

    /**
     * Destroy item of model by id :id.
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function delete($id)
    {
        try {
            return $this->model->destroy($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Force destroy item of model by id :id.
     *
     * @param $id
     * @param string $field
     * @return mixed
     * @throws Exception
     */
    public function forceDelete($id, $field = 'id')
    {
        try {
            return $this->model->where($field, $id)->forceDelete();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
