<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\CollectPoint;
use Tests\TestCase;

class CollectPointsMyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_my_collect_points()
    {
        $currentUser = $this->authUser();

        $i = 0;
        while($i < 5) {
            $collectPointData = CollectPoint::factory()->make()->getAttributes();
            CollectPoint::create([
                'name' => $collectPointData['name'],
                'phone' => $collectPointData['phone'],
                'telegram' => $collectPointData['telegram'],
                'image' => $collectPointData['image'],
                'address' => $collectPointData['location']['address'],
                'latitude' => $collectPointData['location']['latitude'],
                'longitude' => $collectPointData['location']['longitude'],
                'user_id' => $currentUser->id,
            ]);

            $i++;
        }

        $i = 0;
        while($i < 5) {
            $collectPointData = CollectPoint::factory()->make()->getAttributes();
            CollectPoint::create([
                'name' => $collectPointData['name'],
                'phone' => $collectPointData['phone'],
                'telegram' => $collectPointData['telegram'],
                'image' => $collectPointData['image'],
                'address' => $collectPointData['location']['address'],
                'latitude' => $collectPointData['location']['latitude'],
                'longitude' => $collectPointData['location']['longitude'],
                'user_id' => $currentUser->id + 10,
            ]);

            $i++;
        }

        $i = 0;
        while($i < 3) {
            $collectPointData = CollectPoint::factory()->make()->getAttributes();
            
            $response = $this->postJson(route('collect-point.store'), $collectPointData)->assertCreated();
            $i++;
        }

        $response = $this->getJson(route('collect-point.my'))->assertOk()->json();

        $this->assertEquals(8, count($response));
    }
}
