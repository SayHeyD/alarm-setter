<?php

namespace Tests\Feature;

use App\Models\Temperature;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TemperatureTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function it_fetches_the_newest_temperatures()
    {
        $createdTemp = Temperature::factory()->create();

        $fetchedTemp = Temperature::latest('created_at')->first();

        $this->assertEquals($createdTemp->id, $fetchedTemp->id);
    }
}
