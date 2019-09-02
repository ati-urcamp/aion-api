<?php

namespace Domain\Base\Repositories\Criteria\Traits;

trait FilterWith
{
    protected function filterColumns(array $columns, array $permissions)
    {
        foreach ($columns as $key => $column) {
            if (!in_array($column, $permissions)) {
                unset($columns[$key]);
            }
        }

        return $columns;
    }

    protected function _with($query, string $key, $values)
    {
        if (!is_array($values)) {
            return $this;
        }

        $self = $this;

        $query->with([$key => function ($q) use ($values, $self, $key) {
            $search = $q->getModel()->getSearchFillable();
            $modelName = class_basename($q->getModel());
            foreach ($values as $item) {
                foreach ($item as $field => $value) {
                    if ($field == '_columns') {
                        //$fields = $self->filterColumns($value, $search);
                        if (!empty($value)) {
                            foreach ($value as $currentField) {
                                if (!in_array($currentField, $search) && $currentField !== '*') {
                                    throw new \Exception("Field {$currentField} in model {$modelName} not searchable.");
                                }
                            }
                            $q->select($value);
                        }
                        continue;
                    }
                    /*
                    if (!in_array($field, $search)) {
                        throw new \Exception("Field {$field} in model {$modelName} not searchable.");
                        continue;
                    }
                    */
                    $self->decide($field, $value, $q);
                    continue;
                }
            }
        }]);

        return $this;
    }
}
