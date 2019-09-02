<?php

namespace Domain\Base\Examples\Units\Post;

use Domain\Base\Models\BaseAuthModel;

class Post extends BaseAuthModel
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'author',
        'content',
    ];

    protected $searchFillable = [
        'id',
        'title',
        'description',
        'status',
        'author',
        'content',
    ];
}
