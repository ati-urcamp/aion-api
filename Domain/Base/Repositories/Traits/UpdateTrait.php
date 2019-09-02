<?php

namespace Domain\Base\Repositories\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Log;

trait UpdateTrait
{

    /**
     * Update item of model.
     *
     * @param array $data
     * @param int $id
     * @return Model|array
     *
     * @throws Exception
     */
    public function update(array $data, int $id)
    {
        try {
            if (empty($data)) {
                throw new Exception('Empty data');
            }

            $model = $this->model->find($id);
            if (!$model) {
                throw new Exception('Item not found');
            }

            $model->fill($data);
            $model->save();
            return $this->model->find($model->id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
