<?php

$search = [
    'field1'  => 'value',
    'field3'  => [
        'like' => '%value%',
    ],
    'field4'  => [
        'notLike' => '%value%',
    ],
    'field5'  => [
        'ilike' => '%value%',
    ],
    'field6'  => [
        'notIlike' => '%value%',
    ],
    'field7'  => [
        'different' => 'value',
    ],
    'field8'  => [
        'in' => ['value1', 'value2', 'value...'],
    ],
    'field9'  => [
        'notIn' => ['value1', 'value2', 'value...'],
    ],
    'field10'  => [
        '>' => 'value1',
    ],
    'field11'  => [
        '<' => 'value1',
    ],
    'field12'  => [
        '>=' => 'value1',
    ],
    'field13'  => [
        '<=' => 'value1',
    ],
    'field14' => [
        'between' => ['value', 'value2'],
    ],
    'field15' => [ // field->It is then relation name
        'has' => [
            [
                'field1' => 'value1',
                'field2' => 'value2',
            ],
        ],
    ],
    'field16' => [ // field->It is the relation name
        'doesntHave' => [
            [
                'field1' => 'value1',
                'field2' => 'value2',
            ],
        ],
    ],
    'field17' => [ // field->This is then relation name
        'with' => [
            'field1'   => 'value1',
            'field2'   => 'value2',
            '_columns' => [
                'id', 'name',
            ],
        ],
    ],
    'field18' => [ // field->[this is the relation name/only one attach, it isn't a table field]
        'and' => [
            'field1' => 'value1',
            'field2' => 'value2',
        ],
    ],
    'field19' => [ // field->[this is the relation name/only one attach, it isn't a table field]
        'or' => [
            'field1' => 'value1',
            'field2' => 'value2',
        ],
    ],
    'field20' => [ // field->[this is the relation name/only one attach, it isn't a table field]
        'block' => [
            'and' => [
                'field1' => 'value1',
                'field2' => 'value2',
            ],
        ],
    ],
    'field21' => [ // field->[this is the relation name/only one attach, it isn't a table field]
        'block' => [
            'or' => [
                'doesntHave' => [
                    [
                        'field1' => 'value1',
                        'field2' => 'value2',
                    ],
                ],
            ],
        ],
    ],
];

/*
 * Format of JSON for search.
 *
 * {
 *        'field1': 'value',//->where field = :value
 *        'field3': { 'like' : '%value%' }, //->where field like :value
 *        'field4': { 'notLike' : '%value%' }, //->where field not like :value
 *        'field5': { 'ilike' : '%value%' }, //(isso não tem no mysq})
 *        'field6': { 'notIlike' : '%value%' }, //(isso não tem no mysq})
 *        'field7': { 'different' : 'value' }, //->where field != :value
 *        'field8': { 'in' : ['value1', 'value2', 'value3', 'value4'] }, //->where field in (:values)
 *        'field9': { 'notIn' : ['value1', 'value2', 'value3', 'value4'] }, //->where field in (:values)
 *        'field10': { '>' : 'value' }, //->where field > :value
 *        'field11': { '<' : 'value' }, //->where field < :value
 *        'field12': { '>=' : 'value' }, //->where >= :value
 *        'field13': { '<=' : 'value' }, //->where <= :value
 *        'field14': { 'between' : ['value1', 'value2'] } //->where between :value1 and :value2
 *        'field15': {"has": [ { "id": 6979 } ] }
 *        'field16': {"doesntHave": [ { "id": 6979 } ] }
 *        'field17': {"with": [ { "id": 6979 } ] }
 *        'field18': {"and": {"doesntHave": [ { "id": 6979 } ] } }
 *        'field19': {"or": {"doesntHave": [ { "id": 6979 } ] } }
 *        'field20': {"block": "and", "values": [ { } ] }
 *        'field21': {"block": "or", "values": [ { } ] }
 * }.
 */
