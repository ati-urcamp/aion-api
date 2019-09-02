<?php

namespace Domain\Base\Tests\Methods;

trait AllTestTraits
{
    use TestIndexTrait,
        TestShowTrait,
        TestSearchTrait,
        TestStoreTrait,
        TestUpdateTrait,
        TestDeleteTrait;
}
