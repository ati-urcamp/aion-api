<?php

namespace Domain\Base\Tests\Methods;

trait TestIndexTrait
{
    /** @test */
    public function it_should_list_all_records()
    {
        $response = $this->api("GET", $this->getEndpoint());
        $response->assertStatus(200);
    }
}
