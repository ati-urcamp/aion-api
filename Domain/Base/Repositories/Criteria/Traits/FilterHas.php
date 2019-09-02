<?php

namespace Domain\Base\Repositories\Criteria\Traits;

trait FilterHas
{
    protected function _has($query, string $key, $values)
    {
        if (!is_array($values)) {
            return $this;
        }
        $self = $this;

        $query->whereHas($key, function ($q) use ($values, $self) {
            $search = $q->getModel()->getSearchFillable();
            foreach ($values as $item) {
                foreach ($item as $field => $value) {
                    if (!in_array($field, $search)) {
                        continue;
                    }
                    $self->decide($field, $value, $q);
                }
            }
        });

        return $this;
    }
}
