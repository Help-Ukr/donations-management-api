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

    /**
     * @OA\Get(
     *     path="/api/item-category/{itemCategoryId}",
     *     summary="Get item categories record details",
     *     tags={"Item Category CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Parameter(
     *         description="ID item category",
     *         in="path",
     *         name="itemCategoryId",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ItemCategory")
     *     ),
     *     @OA\Response(
     *             response="401",
     *             description="Unauthenticated",
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
    public function show(ItemCategory $itemCategory)
    {
        return response($itemCategory);
    }

    /**
     * @OA\Put(
     *     path="/api/item-category",
     *     summary="Create item categories record",
     *     tags={"Item Category CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Input data format",
     *         @OA\JsonContent(
     *            required={"name"},
     *            @OA\Property(property="name", type="string", example="food"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ItemCategory"),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Entity",
     *     ),
     *     @OA\Response(
     *         response="429",
     *         description="Too Many Requests",
     *     ),
     * )
     *
     * @param ItemCategoryRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(ItemCategoryRequest $request)
    {
        return ItemCategory::create($request->all());
    }

    /**
     * @OA\Delete(
     *     path="/api/item-category/{itemCategoryId}",
     *     summary="Delete item category record",
     *     tags={"Item Category CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Parameter(
     *         description="ID item category",
     *         in="path",
     *         name="itemCategoryId",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *             response="401",
     *             description="Unauthenticated",
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
    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Patch(
     *     path="/api/item-category/{itemCategoryId}",
     *     summary="Update item category record",
     *     tags={"Item Category CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Parameter(
     *         description="ID item category",
     *         in="path",
     *         name="itemCategoryId",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *           name="name",
     *           in="query",
     *           required=true,
     *           @OA\Schema(
     *                 type="string"
     *           )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ItemCategory")
     *     ),
     *     @OA\Response(
     *             response="401",
     *             description="Unauthenticated",
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
    public function update(ItemCategoryRequest $request, ItemCategory $itemCategory)
    {
        $itemCategory->update($request->all());

        return response($itemCategory);
    }
}
