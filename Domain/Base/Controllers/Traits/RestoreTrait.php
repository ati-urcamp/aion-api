<?php

namespace Domain\Base\Controllers\Traits;

trait RestoreTrait
{
    /**
     * Restore :item.
     *
     * @param  int $id
     *
     * @return mixed
     */
    public function restore(int $id)
    {
        return $this->getRepo()->restore($id);
    }
}
