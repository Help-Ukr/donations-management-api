<?php

namespace App\Http\Controllers;

use App\Models\CollectPoint;
use App\Actions\CollectPointFilterAction;
use App\Actions\CollectPointMyAction;
use App\Http\Requests\CollectPointRequest;
use App\Http\Requests\CollectPointFilterRequest;
use Symfony\Component\HttpFoundation\Response;


class CollectPointController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/collect-point",
     *     summary="Get collect points list with filter",
     *     operationId="getCollectionPoint",
     *     tags={"Collect point CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Parameter(
     *         description="Filter collect points by coordinate pair 1 - is the upper left corner, coordinate pair 2 - is the lower right corner",
     *         in="query",
     *         name="bbox",
     *         required=false,
     *         example="51.3269812,26.5834494,47.9900323,37.6214393",
     *         @OA\Schema(
     *            type="text",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Filter collect points by items category id",
     *         in="query",
     *         name="itemsAvailable",
     *         required=false,
     *         example="3,5,10,11",
     *         @OA\Schema(
     *            type="text",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CollectPoint"))
     *     ),
     *     @OA\Response(
     *         response="429",
     *         description="Too Many Requests",
     *    ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthenticated",
     *     ),
     * )
     *
     * @param CollectPointFilterRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function index(CollectPointFilterRequest $request, CollectPointFilterAction $action)
    {
        return response($action->handle($request->validated()));
    }

    /**
     * @OA\Get(
     *     path="/api/collect-point/my",
     *     summary="Get collect points of current user",
     *     operationId="getCollectionPointsMy",
     *     tags={"Collect point CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CollectPoint"))
     *     ),
     *     @OA\Response(
     *         response="429",
     *         description="Too Many Requests",
     *    ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthenticated",
     *     ),
     * )
     *
     * @param CollectPointFilterRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function getMyPoints(CollectPointMyAction $action)
    {
        return response($action->handle());
    }

    /**
     * @OA\Get(
     *     path="/api/collect-point/{collectPointId}",
     *     summary="Get collect point record details",
     *     operationId="queryCollectionPoint",
     *     tags={"Collect point CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Parameter(
     *         description="ID collect point",
     *         in="path",
     *         name="collectPointId",
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
     *         @OA\JsonContent(ref="#/components/schemas/CollectPoint")
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
    public function show(CollectPoint $collectPoint)
    {
        $collectPoint->load(['neededItems', 'availableItems']);
        return response($collectPoint);
    }

    /**
     * @OA\Post(
     *     path="/api/collect-point",
     *     summary="Create collect point record",
     *     operationId="createCollectionPoint",
     *     tags={"Collect point CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Input data format",
     *         @OA\JsonContent(
     *            required={"name", "location"},
     *            @OA\Property(property="name", type="string", example="Space Meduza"),
     *            @OA\Property(property="phone", type="sring", title="Collect point contact phone number", example="+491767890123"),
     *            @OA\Property(property="telegram", type="sring", title="Collect point telegram account", example="@jax21ukr"),
     *            @OA\Property(property="image", type="sring", title="Collect point logo image", example="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png"),
     *            @OA\Property(property="needed_items", type="array",
     *                  @OA\Items( type="object",
     *                      @OA\Property(
     *                          property="item_category_id",
     *                          type="integer",
     *                          example="2"
     *                      ),
     *                  ),
     *            ),
     *            @OA\Property(property="available_items", type="array",
     *                  @OA\Items( type="object",
     *                      @OA\Property(
     *                          property="item_category_id",
     *                          type="integer",
     *                          example="2"
     *                      ),
     *                      @OA\Property(
     *                          property="quantity",
     *                          type="integer",
     *                          example="10"
     *                      ),
     *                  ),
     *            ),
     *            @OA\Property(property="location", type="object", required={"address", "latitude", "longitude"},
     *                          @OA\Property(
     *                              property="address",
     *                              type="string",
     *                              example="Skalitzer Straße 80, 10990 Berlin"
     *                          ),
     *                          @OA\Property(
     *                              property="latitude",
     *                              type="number",
     *                              format="double",
     *                              example="59.334591"
     *                          ),
     *                          @OA\Property(
     *                              property="longitude",
     *                              type="number",
     *                              format="double",
     *                              example="18.06324"
     *                          ),
     *            ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CollectPoint"),
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
     * @param CollectPointRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CollectPointRequest $request)
    {
        $requestData = $request->validated();
        $requestData['address'] = $requestData['location']['address'];
        $requestData['latitude'] = $requestData['location']['latitude'];
        $requestData['longitude'] = $requestData['location']['longitude'];
        unset($requestData['location']);
        $requestData['user_id'] = \Auth::user()->id;

        $collectPoint = CollectPoint::create($requestData);
        $collectPoint->neededItems()->createMany($requestData['needed_items']);
        $collectPoint->availableItems()->createMany($requestData['available_items']);

        $collectPoint->load(['neededItems', 'availableItems']);
        return $collectPoint;
    }

    /**
     * @OA\Delete(
     *     path="/api/collect-point/{collectPointId}",
     *     summary="Delete collect point record",
     *     operationId="deleteCollectionPoint",
     *     tags={"Collect point CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Parameter(
     *         description="ID collect point",
     *         in="path",
     *         name="collectPointId",
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
    public function destroy(CollectPoint $collectPoint)
    {
        $collectPoint->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Patch(
     *     path="/api/collect-point/{collectPointId}",
     *     summary="Update icollect point record",
     *     operationId="updateCollectionPoint",
     *     tags={"Collect point CRUD"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Parameter(
     *         description="ID collect point",
     *         in="path",
     *         name="collectPointId",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *            type="integer",
     *            format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Input data format",
     *         @OA\JsonContent(
     *            required={"name", "location"},
     *            @OA\Property(property="name", type="string", example="new name"),
     *            @OA\Property(property="phone", type="sring", title="Collect point contact phone number", example="+491767890123"),
     *            @OA\Property(property="telegram", type="sring", title="Collect point telegram account", example="@jax21ukr"),
     *            @OA\Property(property="image", type="sring", title="Collect point logo image", example="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png"),
     *            @OA\Property(property="location", type="object", required={"address", "latitude", "longitude"},
     *                          @OA\Property(
     *                              property="address",
     *                              type="string",
     *                              example="new address"
     *                          ),
     *                          @OA\Property(
     *                              property="latitude",
     *                              type="number",
     *                              format="double",
     *                              example="9.9999"
     *                          ),
     *                          @OA\Property(
     *                              property="longitude",
     *                              type="number",
     *                              format="double",
     *                              example="8.8888"
     *                          ),
     *            ),
     *            @OA\Property(property="needed_items", type="array",
     *                @OA\Items( type="object",
     *                     @OA\Property(
     *                         property="item_category_id",
     *                         type="integer",
     *                         example="2"
     *                     ),
     *                ),
     *           ),
     *           @OA\Property(property="available_items", type="array",
     *                 @OA\Items( type="object",
     *                     @OA\Property(
     *                         property="item_category_id",
     *                         type="integer",
     *                         example="2"
     *                     ),
     *                     @OA\Property(
     *                         property="quantity",
     *                         type="integer",
     *                         example="10"
     *                     ),
     *                 ),
     *           ),
     *        ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CollectPoint")
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
    public function update(CollectPointRequest $request, CollectPoint $collectPoint)
    {
        $requestData = $request->validated();
        $requestData['address'] = $requestData['location']['address'];
        $requestData['latitude'] = $requestData['location']['latitude'];
        $requestData['longitude'] = $requestData['location']['longitude'];
        unset($requestData['location']);
        $collectPoint->update($requestData);
        $collectPoint->neededItems()->delete();
        $collectPoint->availableItems()->delete();
        $collectPoint->neededItems()->createMany($requestData['needed_items']);
        $collectPoint->availableItems()->createMany($requestData['available_items']);

        $collectPoint->load(['neededItems', 'availableItems']);
        return response($collectPoint);
    }
}
