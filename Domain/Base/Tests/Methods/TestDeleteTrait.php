<?php

namespace Domain\Base\Tests\Methods;

trait TestDeleteTrait
{
    /** @test */
    public function it_should_delete_a_app()
    {
        $record = $this->getRecord();
        $response = $this->api("DELETE", $this->getEndpoint() . "/{$record->id}");
        $response->assertStatus(200)->assertJsonStructure(['delete']);
    }
}
