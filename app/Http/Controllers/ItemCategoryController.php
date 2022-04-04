<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use App\Http\Requests\ItemCategoryRequest;
use Symfony\Component\HttpFoundation\Response;

class ItemCategoryController extends Controller
{  
    /**
     * @OA\Get(
     *     path="/api/item-category",
     *     summary="Get item categories list",
     *     operationId="getItemCategories",
     *     tags={"Item Category CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ItemCategory"))
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response="429",
     *         description="Too Many Requests",
     *     ),
     * )
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function index()
    {
        $itemCategory = ItemCategory::all();
        return response($itemCategory);
    }
}
