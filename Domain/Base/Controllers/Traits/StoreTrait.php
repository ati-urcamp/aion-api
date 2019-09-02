<?php

namespace Domain\Base\Controllers\Traits;

trait StoreTrait
{
    /**
     * Store new :item.
     *
     * @return mixed
     */
    public function store()
    {
        $request = $this->app->make($this->storeRequest());
        return handleResponses($this->getRepo()->store($request->all()));
    }

    abstract protected function storeRequest();
}
