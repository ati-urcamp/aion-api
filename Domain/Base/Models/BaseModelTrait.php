<?php

namespace Domain\Base\Models;

trait BaseModelTrait
{
    public function getSearchFillable()
    {
        if (property_exists($this, 'searchFillable')) {
            return $this->searchFillable;
        }

        return $this->fillable;
    }
}
