<?php

namespace Domain\Base\Repositories\Criteria\Traits;

trait Decide
{
    /**
     * Decide fields.
     * @param  string $field
     * @param  string|array $value
     * @param  Builder|HasMany
     */
    public function decide(string $field, $value, $query = null, $debug = false)
    {
        if (is_null($query)) {
            $query = $this->query;
        }

        $search = $query->getModel()->getSearchFillable();
        //$firstLetter = substr($field, 0, 1);
        if ($this->isField($field, $value) and !in_array($field, $search)) {
            //throw new \Exception("Field {$field} not searchable.");
            return;
        }

        /**
         * where $field = $value.
         */
        if (!is_array($value)) {
            $query->where($field, $value);
            return;
        }

        if (isset($value['block'])) {
            $this->block($this->query, $field, $value['block']);

            return;
        }

        if (isset($value['has'])
            || isset($value['orHas'])
            || isset($value['doesntHave'])
            || isset($value['orDoesntHave'])
            || isset($value['with'])
        ) {
            $this->hasWith($field, $value);
            return;
        }

        if (isset($value['and'])) {
            $this->_and($this->query, $value['and']);
            return;
        }

        if (isset($value['or'])) {
            $this->_or($this->query, $value['or']);
            return;
        }

        /**
         * where $field = $value.
         */
        if (isset($value['='])) {
            $query->where($field, $value['=']);
            return;
        }

        /**
         * where $field like $value.
         */
        if (isset($value['like'])) {
            $query->where($field, 'like', $value['like']);
            return;
        }

        /**
         * where $field ilike $value.
         */
        if (isset($value['ilike'])) {
            $query->where($field, 'ilike', $value['ilike']);
            return;
        }

        /**
         * where $field not like $value.
         */
        if (isset($value['notLike'])) {
            $query->where($field, 'not like', $value['notLike']);
            return;
        }

        /**
         * where $field not ilike $value.
         */
        if (isset($value['notIlike'])) {
            $query->where($field, 'not ilike', $value['notIlike']);
            return;
        }

        /**
         * where $field != $value.
         */
        if (isset($value['!='])) {
            $query->where($field, '!=', $value['!=']);
            return;
        }

        /**
         * where $field in ($value).
         */
        if (isset($value['in'])) {
            if (!is_array($value['in'])) {
                $value['in'] = explode(',', $value['in']);
            }
            $query->whereIn($field, $value['in']);
            return;
        }

        /**
         * where $field not in ($value).
         */
        if (isset($value['notIn'])) {
            if (!is_array($value['notIn'])) {
                $value['notIn'] = explode(',', $value['notIn']);
            }
            $query->whereNotIn($field, $value['notIn']);
            return;
        }

        /**
         * where $field > $value.
         */
        if (isset($value['>'])) {
            $query->where($field, '>', $value['>']);
            return;
        }

        /**
         * where $field < $value.
         */
        if (isset($value['<'])) {
            $query->where($field, '<', $value['<']);
            return;
        }

        /**
         * where $field >= $value.
         */
        if (isset($value['>='])) {
            $query->where($field, '>=', $value['>=']);
            return;
        }

        /**
         * where $field <= $value.
         */
        if (isset($value['<='])) {
            $query->where($field, '<=', $value['<=']);
            return;
        }

        /*
         * where $field between $start and $end.
         */
        if (isset($value['between']) and is_array($value['between'])) {
            if (count($value['between']) !== 2) {
                return;
            }
            $query->whereBetween($field, $value['between']);
            return;
        }

        return;
    }

    public function hasWith($field, $value)
    {
        if (isset($value['has']) and is_array($value['has'])) {
            $this->_has($this->query, $field, $value['has']);
        }

        if (isset($value['orHas']) and is_array($value['orHas'])) {
            $this->_orHas($this->query, $field, $value['orHas']);
        }

        if (isset($value['doesntHave']) and is_array($value['doesntHave'])) {
            $this->_doesntHave($this->query, $field, $value['doesntHave']);
        }

        if (isset($value['orDoesntHave']) and is_array($value['orDoesntHave'])) {
            $this->_orDoesntHave($this->query, $field, $value['doesntHave']);
        }

        if (isset($value['with']) and is_array($value['with'])) {
            $this->_with($this->query, $field, $value['with']);
        }

        return;
    }
}
