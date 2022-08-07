<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ExchangeTest extends TestCase
{
    const GET = 'GET';
    const ROUTE = '/api/exchange';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_twdExchangeJpy()
    {
        $data = [
            "SourceType" => "TWD",
            "TargetType" => "JPY",
            "Price" => "100",
        ];

        $response = $this->json('GET', self::ROUTE, $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_errorSource()
    {
        $data = [
            "SourceType" => "123",
            "TargetType" => "TWD",
            "Price" => "100",
        ];

        $response = $this->json('GET', self::ROUTE, $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_emptyTarget()
    {
        $data = [
            "SourceType" => "TWD",
            "TargetType" => "",
            "Price" => "100",
        ];

        $response = $this->json('GET', self::ROUTE, $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_price()
    {
        $data = [
            "SourceType" => "TWD",
            "TargetType" => "TWD",
            "Price" => "10OO",
        ];

        $response = $this->json('GET', self::ROUTE, $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
