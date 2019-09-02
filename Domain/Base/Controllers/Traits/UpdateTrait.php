<?php

namespace Domain\Base\Controllers\Traits;

trait UpdateTrait
{
    /**
     * Update :item.
     *
     * @param  int $id
     *
     * @return mixed
     */
    public function update(int $id)
    {
        $request = $this->app->make($this->updateRequest());
        return handleResponses($this->getRepo()->update($request->all(), $id));
    }

    abstract protected function updateRequest();
}
