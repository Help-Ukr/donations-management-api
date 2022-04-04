<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ItemCategory;

class ItemCategoryTest extends TestCase
{

    use RefreshDatabase;

    private $itemCategory;

    public function setUp(): void
    {
        parent::setUp(); 
        $this->itemCategory = ItemCategory::factory()->create();

        $this->authUser();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_item_categories()
    {
        $response = $this->getJson(route('item-category.index'))
                    ->assertOk()
                    ->json();

        $this->assertEquals(1, count($response));
        $this->assertEquals($this->itemCategory->name, $response[0]['name']);
    }
}
