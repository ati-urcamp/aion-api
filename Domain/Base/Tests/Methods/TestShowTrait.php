<?php

namespace Domain\Base\Tests\Methods;

trait TestShowTrait
{
    /** @test */
    public function it_should_show_a_record()
    {
        $record = $this->getRecord();
        $response = $this->api("GET", $this->getEndpoint() . "/{$record->id}");
        $response->assertStatus(200)->assertJsonStructure($this->getRecordDataKeys());
    }
}
