<?php

namespace Domain\Base\Controllers\Traits;

trait DeleteTrait
{
    /**
     * Delete :item.
     * @param  int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return handleResponses($this->getRepo()->delete($id));
    }
}
