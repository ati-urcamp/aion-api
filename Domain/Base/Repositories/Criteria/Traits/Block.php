<?php

namespace Domain\Base\Repositories\Criteria\Traits;

trait Block
{
    public function block($query, $field, $value)
    {
        $self = $this;
        if (isset($value['and'])) {
            $values = $value['and'];

            $query->where(function ($q) use ($self, $field, $values) {
                $self->decide($field, $values, $q);
            });
        }

        if (isset($value['or'])) {
            $values = $value['or'];

            $query->orWhere(function ($q) use ($self, $field, $values) {
                $self->decide($field, $values, $q);
            });
        }

        return $this;
    }
}
