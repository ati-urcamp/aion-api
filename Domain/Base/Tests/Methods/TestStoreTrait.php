<?php

namespace Domain\Base\Tests\Methods;

trait TestStoreTrait
{
    /** @test */
    public function it_should_store_a_record()
    {
        $data = $this->getRecordData();
        $data = $this->mergeCustomData($data, $this->getStoreCustomData());
        $response = $this->api("POST", $this->getEndpoint(), $data);
        $response->assertStatus(200)->assertJsonStructure($this->getRecordDataKeys());
    }

    /** @test */
    public function it_should_not_store_a_record()
    {
        $data = $this->getRecordWithMissingData();
        $data = $this->mergeCustomData($data, $this->getStoreCustomData());
        $response = $this->api("POST", $this->getEndpoint(), $data);
        $response->assertStatus(422)->assertJsonStructure(['error']);
    }
}
