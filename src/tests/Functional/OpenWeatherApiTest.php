<?php

namespace Tests\Functional;

use Tests\TestCase;

final class OpenWeatherApiTest extends TestCase
{
    /**
     * We're implementing external api's, for small cases its fine to hit the api's directly and test functionally.
     *
     * @return void
     */
    public function testGetWeatherForecastSuccessfully(): void
    {
        $url = \sprintf('api/weather-forecast?city=%s', 'Manila');
        $this->json('GET', $url)
            ->assertStatus(200)
            ->assertJsonFragment(['name'=> 'Manila']);
    }

    public function testWeatherForecastFailsOnMissingParameters(): void
    {
        $this->json('GET', 'api/weather-forecast')
            ->assertStatus(422)
            ->assertSee('[ERROR]');
    }
}
