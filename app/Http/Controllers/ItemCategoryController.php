<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use App\Http\Requests\ItemCategoryRequest;
use Symfony\Component\HttpFoundation\Response;

class ItemCategoryController extends Controller
{
    public function index()
    {
        $itemCategory = ItemCategory::all();
        return response($itemCategory);
    }

    public function show(ItemCategory $itemCategory)
    {
        return response($itemCategory);
    }

    public function store(ItemCategoryRequest $request)
    {
        return ItemCategory::create($request->all());
    }

    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function update(ItemCategoryRequest $request, ItemCategory $itemCategory)
    {
        $itemCategory->update($request->all());

        return response($itemCategory);
    }
}
