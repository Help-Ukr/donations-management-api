<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ItemCategory;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ItemCategoryTest extends TestCase
{

    use RefreshDatabase;

    private $itemCategory;

    public function setUp(): void
    {
        parent::setUp(); 
        $this->itemCategory = ItemCategory::factory()->create();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_item_categories()
    {
        $responce = $this->getJson(route('item-category.index'))
                    ->assertOk()
                    ->json();

        $this->assertEquals(1, count($responce));
        $this->assertEquals($this->itemCategory->name, $responce[0]['name']);
    }

    public function test_get_single_item_category()
    {
        $responce = $this->getJson(route('item-category.show',  $this->itemCategory->id))
                        ->assertOk()
                        ->json();
                        

        $this->assertEquals($this->itemCategory->name, $responce['name']);
    }

    public function test_store_new_item_category()
    {
        $itemCategory = ItemCategory::factory()->make();
        $response = $this->postJson(route('item-category.store'), $itemCategory->toArray())
                ->assertCreated()
                ->json();

        $this->assertEquals($response['name'], $itemCategory->name);

        $this->assertDatabaseHas('item_categories', $itemCategory->toArray());
    }

    public function test_while_storing_item_category_name_field_is_required()
    {
        $this->withExceptionHandling();

        $response = $this->postJson(route('item-category.store'))
                        ->assertUnprocessable();

        $response->assertJsonValidationErrors(['name']);
    }

    public function test_detele_item_category()
    {
        $this->deleteJson(route('item-category.destroy', $this->itemCategory->id))
                ->assertNoContent();

        $this->assertDatabaseMissing('item_categories', $this->itemCategory->toArray());
    }

    public function test_update_item_category()
    {
        $this->patchJson(route('item-category.update', $this->itemCategory->id), ['name' => 'updated name'])
                ->assertOk();

        $this->assertDatabaseHas('item_categories', ['id' => $this->itemCategory->id, 'name' => 'updated name']);
    }

    public function test_while_updating_item_category_name_field_is_required()
    {
        $this->withExceptionHandling();

        $response = $this->patchJson(route('item-category.update', $this->itemCategory->id))
                        ->assertUnprocessable();

        $response->assertJsonValidationErrors(['name']);
    }

}
