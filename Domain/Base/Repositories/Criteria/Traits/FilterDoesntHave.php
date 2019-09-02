<?php

namespace Domain\Base\Repositories\Criteria\Traits;

trait FilterDoesntHave
{
    protected function _DoesntHave($query, string $key, $values)
    {
        if (!is_array($values)) {
            return $this;
        }
        $self = $this;

        $query->whereDoesntHave($key, function ($q) use ($values, $self) {
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
