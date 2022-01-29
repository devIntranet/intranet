<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IntranetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
       $response = $this->post('/komputery' ,[
           'dns_k' => 'GG2',
           'ip_k' => '192.168.10.11',
       ]);
       $response->assertOk();
       $this->assertCount(1, Komputery::all());
    }
}
