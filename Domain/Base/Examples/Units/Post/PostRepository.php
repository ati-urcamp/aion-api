<?php

namespace Domain\Base\Examples\Units\Post;

use Domain\Base\Repositories\BaseRepository;

class PostRepository extends BaseRepository
{
    public function model()
    {
        return Post::class;
    }
}
