<?php

namespace Tests\Functional;

use Tests\TestCase;

final class FourSquareApiTest extends TestCase
{
    /**
     * We're implementing external api's, for small cases its fine to hit the api's directly and test functionally.
     *
     * @return void
     */
    public function testGetPlacesSuccessfully(): void
    {
        $url = \sprintf('api/places?city=%s', 'Manila');
        $response = $this->get($url);
        $actual = (array) json_decode($response->getContent())->results ?? [];

        $response->assertStatus(200);
        $this->assertNotEmpty($actual);
        $this->assertArrayHasKey('fsq_id', (array) $actual[0]);
    }

    public function testGetPlacesWithLimitSuccessfully(): void
    {
        $url = \sprintf('api/places?city=%s&limit=10', 'Manila');
        $response = $this->get($url);
        $actual = (array) json_decode($response->getContent())->results ?? [];

        $response->assertStatus(200);
        $this->assertCount(9, $actual);
    }

    public function testGetPlacesFailsOnMissingParameters(): void
    {
        $this->json('GET', 'api/places')
            ->assertStatus(422)
            ->assertSee('[ERROR]');
    }
}
