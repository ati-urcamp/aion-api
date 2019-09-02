<?php

namespace Domain\Base\Tests\Methods;

trait TestSearchTrait
{
    /** @test */
    public function it_should_search_records()
    {
        $this->createRecords(50);
        $data = $this->mergeCustomData([], $this->getSearchCustomData());
        $response = $this->api("POST", $this->getEndpoint() . '/search', $data);
        $response->assertStatus(200)->assertJsonStructure(['data', 'total']);
    }
}
