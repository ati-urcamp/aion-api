<?php

namespace Domain\Base\Repositories\Criteria\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterOr
{
    public function _or(Builder $query, array $values)
    {
        $self = $this;

        $query->orWhere(function ($q) use ($self, $values) {
            foreach ($values as $field => $value) {
                $self->decide($field, $value, $q);
            }
        });

        return $this;
    }
}
