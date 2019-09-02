<?php

namespace Domain\Base\Examples\Tests;

use Illuminate\Foundation\Testing\TestCase;
use Domain\Base\Examples\Units\Post\Post;
use Domain\Base\Tests\BaseApiTest;
use Domain\Base\Tests\Methods\AllTestTraits;

class PostTest extends TestCase
{
    use BaseApiTest;
    use AllTestTraits;

    public function setUp()
    {
        parent::setUp();
        $this->setModelClass(Post::class);
        $this->setEndpoint('v1/post');
        $this->setRequiredFields(['title', 'author', 'active']);
    }

    public function createApplication()
    {
        // TODO: Implement createApplication() method.
    }
}
