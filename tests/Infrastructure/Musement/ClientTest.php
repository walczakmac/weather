<?php

namespace App\Tests\Infrastructure\Musement;

use App\Infrastructure\Musement\Client as MusementClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class ClientTest extends TestCase
{
    public function testGetCities() : void
    {
        $body = [
            [
                'name' => 'London',
                'latitude' => 111.11,
                'longitude' => 222.22
            ]
        ];
        $mock = new MockHandler([new Response(200, [], json_encode($body))]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $logger = new TestLogger();

        $musementClient = new MusementClient($client, $logger);
        $cities = $musementClient->getCities();

        $this->assertCount(1, $cities);
        $this->assertSame('London', $cities[0]['name']);
        $this->assertSame(111.11, $cities[0]['latitude']);
        $this->assertSame(222.22, $cities[0]['longitude']);
    }

    public function testGetCitiesException() : void
    {
        $mock = new MockHandler([
            new ServerException(
                'server exception',
                new Request('GET', 'cities'),
                new Response(500)
            ),
        ]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $logger = new TestLogger();

        $musementClient = new MusementClient($client, $logger);
        $cities = $musementClient->getCities();

        $this->assertEmpty($cities);
        $this->assertTrue($logger->hasErrorThatContains('There was an error when trying to fetch cities data from Musement API: server exception'));
    }

    public function testGetCitiesStatusCode() : void
    {
        $mock = new MockHandler([new Response(204)]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $logger = new TestLogger();

        $musementClient = new MusementClient($client, $logger);
        $cities = $musementClient->getCities();

        $this->assertEmpty($cities);
        $this->assertTrue($logger->hasErrorThatContains('Musement API responded with status code 204 when trying to fetch cities data'));
    }
}
