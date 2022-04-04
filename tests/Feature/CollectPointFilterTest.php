<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CollectPoint;

class CollectPointFilterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp(); 
        $collectPointKyivData = CollectPoint::factory()->make()->getAttributes();
        $this->collectPointKyiv = CollectPoint::create([
            'name' => 'Kyiv',
            'phone' => $collectPointKyivData['phone'],
            'telegram' => $collectPointKyivData['telegram'],
            'image' => $collectPointKyivData['image'],
            'address' => $collectPointKyivData['location']['address'],
            'latitude' => 50.4019514,
            'longitude' => 30.3926095,
        ]);

        $this->collectPointKyiv->neededItems()->createMany($collectPointKyivData['needed_items']);
        $this->collectPointKyiv->load(['neededItems']);

        $collectPointDniproData = CollectPoint::factory()->make()->getAttributes();
        $this->collectPointDnipro = CollectPoint::create([
            'name' => 'Dnipro',
            'phone' => $collectPointDniproData['phone'],
            'telegram' => $collectPointDniproData['telegram'],
            'image' => $collectPointDniproData['image'],
            'address' => $collectPointDniproData['location']['address'],
            'latitude' => 48.4622135,
            'longitude' => 34.8602752,
        ]);

        $this->collectPointDnipro->neededItems()->createMany($collectPointDniproData['needed_items']);
        $this->collectPointDnipro->load(['neededItems']);

        $collectPointVinnytsiaData = CollectPoint::factory()->make()->getAttributes();
        $this->collectPointVinnytsia = CollectPoint::create([
            'name' => 'Vinnytsia',
            'phone' => $collectPointVinnytsiaData['phone'],
            'telegram' => $collectPointVinnytsiaData['telegram'],
            'image' => $collectPointVinnytsiaData['image'],
            'address' => $collectPointVinnytsiaData['location']['address'],
            'latitude' => 49.2347287,
            'longitude' => 28.4346146,
        ]);

        $this->collectPointVinnytsia->neededItems()->createMany($collectPointVinnytsiaData['needed_items']);
        $this->collectPointVinnytsia->load(['neededItems']);

        $collectPointBerlinData = CollectPoint::factory()->make()->getAttributes();
        $this->collectPointBerlin = CollectPoint::create([
            'name' => 'Berlin',
            'phone' => $collectPointBerlinData['phone'],
            'telegram' => $collectPointBerlinData['telegram'],
            'image' => $collectPointBerlinData['image'],
            'address' => $collectPointBerlinData['location']['address'],
            'latitude' => 52.5489461,
            'longitude' => 13.0515077,
        ]);

        $this->collectPointBerlin->neededItems()->createMany($collectPointBerlinData['needed_items']);
        $this->collectPointBerlin->load(['neededItems']);

        $this->authUser();
    }

    /**
     * A basic feature test example.
     * @info https://api.domainname.org/collectionpoint/?bbox={lat1},{lng1},{lat2},{lng2}
     *
     * @return void
     */
    public function test_get_all()
    {
        $this->assertDatabaseHas('collect_points', ['name' => 'Berlin']);
        $this->assertDatabaseHas('collect_points', ['name' => 'Vinnytsia']);
        $this->assertDatabaseHas('collect_points', ['name' => 'Dnipro']);
        $this->assertDatabaseHas('collect_points', ['name' => 'Kyiv']);

        $response = $this->getJson(route('collect-point.index'))
                ->assertOk()
                ->json();

        $this->assertEquals(4, count($response));
    }

    public function test_get_with_wrong_bbox()
    {
        $this->withExceptionHandling();

        $response = $this->getJson(route('collect-point.index', ['bbox' => 'wrong data']))->assertUnprocessable();

        $response->assertJsonValidationErrors(['bbox']);
    }

    public function test_get_by_bbox()
    {
        $response = $this->getJson(route('collect-point.index', ['bbox' => '51.3269812,26.5834494,47.9900323,37.6214393']))
                            ->assertOk()
                            ->json();

        $this->assertEquals(3, count($response));
    }
}
