<?php

namespace Domain\Base\Examples\Units\Post;

use Domain\Base\Controllers\AbstractController;
use Domain\Base\Controllers\Traits\DeletesTrait;
use Domain\Base\Controllers\Traits\GetsTrait;
use Domain\Base\Controllers\Traits\StoreTrait;
use Domain\Base\Controllers\Traits\UpdateTrait;
use Domain\Base\Examples\Units\Post\Requests\StoreRequest;
use Domain\Base\Examples\Units\Post\Requests\UpdateRequest;
use Domain\Base\Examples\Units\Post\PostRepository as Repository;

class PostController extends AbstractController
{
    use GetsTrait, StoreTrait, UpdateTrait, DeletesTrait;

    public function repo()
    {
        return Repository::class;
    }

    public function storeRequest()
    {
        return StoreRequest::class;
    }

    public function updateRequest()
    {
        return UpdateRequest::class;
    }
}
