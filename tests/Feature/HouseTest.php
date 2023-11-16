<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\SubdistrictSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HouseTest extends TestCase
{
    use RefreshDatabase;

    private $user1;

    private $validHouseBody = [
        'province_id' => 1,
        'city_id' => 1,
        'subdistrict_id' => 1,
        'price' => 250000000,
        'address' => 'Jl. mam Bonjol',
        'description' => 'Rumah ini adalah pilihan sempurna untuk mereka yang mencari hunian yang nyaman dan fungsional.',
        'type' => 0,
        'building_area' => 120,
        'land_length' => 12,
        'land_width' => 10,
        'bedroom' => 5,
        'bathroom' => 4,
        'floor' => 2,
        'headline' => 'DIJUAL Rumah 2 Lantai Batam Center',
        'iframe' => 'iframecode',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();

        $seeder = new SubdistrictSeeder();
        $seeder->run();
    } 

    public function testUserCanCreateHouse(): void
    {
        $user = $this->user1;

        $response = $this->actingAs($user)->postJson('/api/v1/houses', $this->validHouseBody);

        $response->assertStatus(201);
        $this->assertDatabaseCount('houses', 1)
            ->assertDatabaseHas('houses', $this->validHouseBody);
    }

    public function testUserCannotCreateHouseWithMissingPrice(): void
    {
        $user = $this->user1;
        $invalidHouseBody = $this->validHouseBody;
        unset($invalidHouseBody['price']);

        $response = $this->actingAs($user)->postJson('/api/v1/houses', $invalidHouseBody);

        $response->assertStatus(422);
        $this->assertDatabaseCount('houses', 0);
    }
}
