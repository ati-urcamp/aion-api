<?php

namespace Domain\Base\Tests\Methods;

trait TestUpdateTrait
{
    /** @test */
    public function it_should_update_a_record()
    {
        $record = $this->getRecord();
        $data = $this->getRecordData();
        $data = $this->mergeCustomData($data, $this->getUpdateCustomData());
        $response = $this->api("PUT", $this->getEndpoint() . "/{$record->id}", $data);
        $response->assertStatus(200)->assertJsonStructure($this->getRecordDataKeys());
    }

    /** @test */
    public function it_should_not_update_a_record()
    {
        $record = $this->getRecord();
        $data = $this->getRecordWithMissingData();
        $data = $this->mergeCustomData($data, $this->getUpdateCustomData());
        $response = $this->api("PUT", $this->getEndpoint() . "/{$record->id}", $data);
        $response->assertStatus(422)->assertJsonStructure(['error']);
    }
}
