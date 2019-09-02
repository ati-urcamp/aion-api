<?php

namespace Domain\Base\Repositories\Criteria\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterAnd
{
    public function _and(Builder $query, array $values)
    {
        $self = $this;
        $query->where(function ($q) use ($self, $values) {

            $i = 0;
            foreach ($values as $field => $value) {
                $self->decide($field, $value, $q, $i);
                $i++;
            }
        });

        return $this;
    }
}
