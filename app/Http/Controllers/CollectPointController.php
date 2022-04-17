<?php

namespace App\Http\Controllers;

use App\Models\CollectPoint;
use App\Actions\CollectPointFilterAction;
use App\Actions\CollectPointMyAction;
use App\Actions\CollectPointPhotoAction;
use App\Http\Requests\CollectPointRequest;
use App\Http\Requests\CollectPointPhotoRequest;
use App\Http\Requests\CollectPointStoreRequest;
use App\Http\Requests\CollectPointFilterRequest;
use Symfony\Component\HttpFoundation\Response;


class CollectPointController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/collect-point",
     *     summary="Get collect points list with filter",
     *     operationId="getCollectionPoint",
     *     tags={"Collect point"},
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
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CollectPoint"))
     *     ),
     *     @OA\Response(
     *         response="429",
     *         description="Too Many Requests",
     *    ),
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
     *     tags={"Collect point"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CollectPoint")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No data found",
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
        $collectPoint = $action->handle();
        
        if(is_null($collectPoint)) {
            return response('no data found', Response::HTTP_NO_CONTENT);
        }

        return response($collectPoint);
    }

    /**
     * @OA\Post(
     *     path="/api/collect-point/photo",
     *     summary="Store collect point photo",
     *     operationId="storeCollectionPointPhoto",
     *     tags={"Collect point"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"photo"},
     *                 @OA\Property(
     *                     description="collect point photo to upload. Max size 2M.",
     *                     property="photo",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *            required={"url"},
     *            @OA\Property(property="url", type="string", example="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png"),
     *         ),
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
     * @param CollectPointPhotoRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function photo(CollectPointPhotoRequest $request, CollectPointPhotoAction $action)
    {
        return [
            'url' => $action->handle($request->file('photo')->getPathName())
        ];
    }

    /**
     * @OA\Post(
     *     path="/api/collect-point",
     *     summary="Create collect point record",
     *     operationId="createCollectionPoint",
     *     tags={"Collect point"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Input data format",
     *         @OA\JsonContent(
     *            required={"name", "location"},
     *            @OA\Property(property="enabled", type="boolean", example="true"),
     *            @OA\Property(property="name", type="string", example="Space Meduza"),
     *            @OA\Property(property="phone", type="string", title="Collect point contact phone number", example="+491767890123"),
     *            @OA\Property(property="telegram", type="string", title="Collect point telegram account", example="@jax21ukr"),
     *            @OA\Property(property="instagram", type="string", title="Collect point instagram account", example="@insta"),
     *            @OA\Property(property="image", type="string", title="Collect point logo image", example="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png"),
     *            @OA\Property(property="needed_items", type="array",
     *                  @OA\Items( type="object", required={"item_category_id"},
     *                      @OA\Property(
     *                          property="item_category_id",
     *                          type="integer",
     *                          example="2"
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
     * @param CollectPointStoreRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CollectPointStoreRequest $request)
    {
        $requestData = $request->validated();
        $requestData['address'] = $requestData['location']['address'];
        $requestData['latitude'] = $requestData['location']['latitude'];
        $requestData['longitude'] = $requestData['location']['longitude'];
        unset($requestData['location']);
        $requestData['user_id'] = \Auth::user()->id;

        $collectPoint = CollectPoint::create($requestData);
        $collectPoint->neededItems()->createMany($requestData['needed_items']);

        $collectPoint->load(['neededItems']);
        return $collectPoint;
    }

    /**
     * @OA\Patch(
     *     path="/api/collect-point",
     *     summary="Update icollect point record",
     *     operationId="updateCollectionPoint",
     *     tags={"Collect point"},
     *     security={
     *           {"bearerAuth":{}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         description="Input data format",
     *         @OA\JsonContent(
     *            required={"name", "location"},
     *            @OA\Property(property="enabled", type="boolean", example="true"),
     *            @OA\Property(property="name", type="string", example="new name"),
     *            @OA\Property(property="phone", type="string", title="Collect point contact phone number", example="+491767890123"),
     *            @OA\Property(property="telegram", type="string", title="Collect point telegram account", example="@jax21ukr"),
     *            @OA\Property(property="instagram", type="string", title="Collect point instagram account", example="@insta"),
     *            @OA\Property(property="image", type="string", title="Collect point logo image", example="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png"),
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
     *                @OA\Items( type="object", required={"item_category_id"},
     *                     @OA\Property(
     *                         property="item_category_id",
     *                         type="integer",
     *                         example="2"
     *                     ),
     *                ),
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
    public function update(CollectPointRequest $request)
    {
        $requestData = $request->validated();
        $requestData['address'] = $requestData['location']['address'];
        $requestData['latitude'] = $requestData['location']['latitude'];
        $requestData['longitude'] = $requestData['location']['longitude'];
        unset($requestData['location']);
        $collectPoint = CollectPoint::where('user_id', \Auth::user()->id)->first();
        $collectPoint->update($requestData);
        $collectPoint->neededItems()->delete();
        $collectPoint->neededItems()->createMany($requestData['needed_items']);

        $collectPoint->load(['neededItems']);
        return response($collectPoint);
    }
}
