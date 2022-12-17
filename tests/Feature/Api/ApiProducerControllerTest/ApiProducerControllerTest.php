<?php

namespace Tests\Feature\Api\ApiProducerControllerTest;

use App\Models\Producer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiProducerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $producer;

    protected function setUp() : void
    {
        parent::setUp();
        $this->given_producer();
    }

    public function given_producer() 
    {
        $this->producer = Producer::factory()->create(["name" => "abc"]);
    } 

    public function test_get_producer()
    {
        dd($this->producer->id);
    }
}
