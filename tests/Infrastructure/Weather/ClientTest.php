<?php

namespace App\Tests\Infrastructure\Weather;

use App\Infrastructure\Weather\Client as WeatherClient;
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
    public function testGetForecastByLatLong() : void
    {
        $body = [
            'forecast' => [
                'forecastday' => [
                    [
                        'date' => '2021-01-30',
                        'day' => ['condition' => ['text' => 'Clear sky']]
                    ],
                ]
            ]
        ];

        $mock = new MockHandler([new Response(200, [], json_encode($body))]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $key = 'abc';
        $logger = new TestLogger();

        $client = new WeatherClient($client, $key, $logger);
        $forecasts = $client->getForecastByLatLong(111.11, 222.22, 2);

        $this->assertNotEmpty($forecasts);
        $this->assertSame('2021-01-30', $forecasts['forecast']['forecastday'][0]['date']);
        $this->assertSame('Clear sky', $forecasts['forecast']['forecastday'][0]['day']['condition']['text']);
    }

    public function testGetForecastByLatLongException() : void
    {
        $mock = new MockHandler([
            new ServerException(
                'server exception',
                new Request('GET', 'cities'),
                new Response(500)
            ),
        ]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $key = 'abc';
        $logger = new TestLogger();

        $client = new WeatherClient($client, $key, $logger);
        $forecasts = $client->getForecastByLatLong(111.11, 222.22, 2);

        $this->assertEmpty($forecasts);
        $this->assertTrue($logger->hasErrorThatContains(
            'There was an error when trying to fetch forecast data from Weather API for following coordinates: 111.11, 222.22: server exception'
        ));
    }

    public function testGetForecastByLatLongStatusCode() : void
    {
        $mock = new MockHandler([new Response(204)]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $key = 'abc';
        $logger = new TestLogger();

        $client = new WeatherClient($client, $key, $logger);
        $forecasts = $client->getForecastByLatLong(111.11, 222.22, 2);

        $this->assertEmpty($forecasts);
        $this->assertTrue($logger->hasErrorThatContains(
            'Weather API responded with status code 204 when trying to fetch forecast data for following coordinates 111.11, 222.22'
        ));
    }
}
