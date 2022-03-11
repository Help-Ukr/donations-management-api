<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\CollectPoint;

class CollectPointsTest extends TestCase
{
    use RefreshDatabase;

    private $collectPoint;

    public function setUp(): void
    {
        parent::setUp(); 
        $collectPointData = CollectPoint::factory()->make()->getAttributes();
        $this->collectPoint = CollectPoint::create([
            'name' => $collectPointData['name'],
            'phone' => $collectPointData['phone'],
            'telegram' => $collectPointData['telegram'],
            'image' => $collectPointData['image'],
            'address' => $collectPointData['location']['address'],
            'latitude' => $collectPointData['location']['latitude'],
            'longitude' => $collectPointData['location']['longitude'],
        ]);

        $this->collectPoint->neededItems()->createMany($collectPointData['needed_items']);
        $this->collectPoint->availableItems()->createMany($collectPointData['available_items']);
        $this->collectPoint->load(['neededItems', 'availableItems']);
    }

    public function test_do_not_allow_for_unauthenticated_users()
    {
        $this->withExceptionHandling();
        $responce = $this->getJson(route('collect-point.index'))
                        ->assertUnauthorized();
    }

    public function test_store_new_collect_point()
    {
        $this->authUser();

        $collectPoint = CollectPoint::factory()->make();
        $response = $this->postJson(route('collect-point.store'), $collectPoint->getAttributes())
                ->assertCreated()
                ->json();

        $collectPointArray = $collectPoint->getAttributes();
        $neededItemsArray = $collectPointArray['needed_items'];
        $availableItemsArray = $collectPointArray['available_items'];

        $collectPointArray['address'] = $collectPointArray['location']['address'];
        $collectPointArray['latitude'] = $collectPointArray['location']['latitude'];
        $collectPointArray['longitude'] = $collectPointArray['location']['longitude'];
        unset($collectPointArray['location'], $collectPointArray['needed_items'], $collectPointArray['available_items']);
        $this->assertDatabaseHas('collect_points', $collectPointArray);

        foreach($neededItemsArray as $row) {
            $row['collect_point_id'] = $response['id'];
            $this->assertDatabaseHas('needed_items', $row);
        }

        foreach($availableItemsArray as $row) {
            $row['collect_point_id'] = $response['id'];
            $this->assertDatabaseHas('available_items', $row);
        }
    }

    public function test_while_storing_collect_point_name_field_is_required()
    {
        $this->authUser();
        $this->withExceptionHandling();

        $response = $this->postJson(route('collect-point.store'))
                        ->assertUnprocessable();

        $response->assertJsonValidationErrors(['name']);
    }

    public function test_get_all_collect_points()
    {
        $this->authUser();

        $responce = $this->getJson(route('collect-point.index'))
                        ->assertOk()
                        ->json();

        $this->assertEquals(1, count($responce));
        $this->assertEquals($this->collectPoint->toArray(), $responce[0]);
    }

    public function test_get_single_collect_point()
    {
        $this->authUser();

        $responce = $this->getJson(route('collect-point.show',  $this->collectPoint->id))
                        ->assertOk()
                        ->json();
                        
        $this->assertEquals($this->collectPoint->toArray(), $responce);
    }

    public function test_detele_collect_point()
    {
        $this->authUser();

        $this->deleteJson(route('collect-point.destroy', $this->collectPoint->id))
                ->assertNoContent();

        $this->assertDatabaseMissing('collect_points', $this->collectPoint->getAttributes());
        $this->assertDatabaseMissing('available_items', ['collect_point_id' => $this->collectPoint->id]);
        $this->assertDatabaseMissing('needed_items', ['collect_point_id' => $this->collectPoint->id]);
    }

    public function test_update_collect_point()
    {
        $this->authUser();
        $oldCollectPoint = $this->collectPoint->toArray();
        $availableItems = [
            ['item_category_id' => rand(0, 10), 'quantity' => rand(0, 100)],
            ['item_category_id' => rand(0, 10), 'quantity' => rand(0, 100)],
            ['item_category_id' => rand(0, 10), 'quantity' => rand(0, 100)],
        ];

        $neededItems = [
            ['item_category_id' => rand(0, 10)],
            ['item_category_id' => rand(0, 10)],
            ['item_category_id' => rand(0, 10)],
        ];

        $responce = $this->patchJson(route('collect-point.update', $this->collectPoint->id), 
                [
                    'name' => 'updated name',
                    'location' => [
                        'address' => 'updated address',
                        'latitude' => $this->collectPoint->latitude,
                        'longitude' => $this->collectPoint->longitude,
                    ],
                    'available_items' => $availableItems,
                    'needed_items' => $neededItems,
                ])
                ->assertOk();

        $this->assertDatabaseHas('collect_points', ['id' => $this->collectPoint->id, 'name' => 'updated name', 'address' => 'updated address']);

        foreach($neededItems as $neededItem) {
            $neededItem['collect_point_id'] = $this->collectPoint->id;
            $this->assertDatabaseHas('needed_items', $neededItem);
        }
        
        foreach($oldCollectPoint['needed_items'] as $row) {
            unset($row['id'], $row['updated_at'], $row['created_at']);
            $this->assertDatabaseMissing('needed_items', $row);
        }

        foreach($availableItems as $availableItem) {
            $availableItem['collect_point_id'] = $this->collectPoint->id;
            $this->assertDatabaseHas('available_items', $availableItem);
        }

        foreach($oldCollectPoint['available_items'] as $row) {
            unset($row['id'], $row['updated_at'], $row['created_at']);
            $this->assertDatabaseMissing('available_items', $row);
        }
    }

    public function test_while_updating_collect_point_name_field_is_required()
    {
        $this->authUser();
        $this->withExceptionHandling();

        $response = $this->patchJson(route('collect-point.update', $this->collectPoint->id))
                        ->assertUnprocessable();

        $response->assertJsonValidationErrors(['name']);
    }
}
