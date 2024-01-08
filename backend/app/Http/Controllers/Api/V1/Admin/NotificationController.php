<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use App\Http\Requests\Admin\Notifications\CreateNotificationRequest;
use App\Http\Requests\Admin\Notifications\UpdateNotificationRequest;
use App\Http\Resources\Admin\Notifications\NotificationResource;

/**
 *  @OA\Tag(
 *      name="Notification",
 *      description="Notification Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="notification",
 *      @OA\Property(
 *          property="id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="title",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="content",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="action",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="date_public",
 *          type="date",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="datetime",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="datetime",
 *          example=1,
 *      ),
 *  )
 */
class NotificationController extends Controller
{
    /**
     * @var  App\Services\NotificationService notificationService
     */
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        // Check permission
        // $this->middleware('permission:notification.show', ['only' => ['show']]);
        // $this->middleware('permission:notification.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:notification.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:notification.destroy', ['only' => ['destroy']]);

        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/notification",
     *      tags={"Notification"},
     *      operationId="indexNotification",
     *      summary="List Notification",
     *      @OA\Parameter(ref="#/components/parameters/page"),
     *      @OA\Parameter(ref="#/components/parameters/limit"),
     *      @OA\Parameter(ref="#/components/parameters/sort"),
     *      @OA\Parameter(ref="#/components/parameters/sortType"),
     *      @OA\Parameter(ref="#/components/parameters/condition"),
     *      @OA\Response(
     *          response=200,
     *          description="Listed",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/notification")
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  ref="#/components/schemas/meta"
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  ref="#/components/schemas/links"
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $notification = $this->notificationService->listNotification($params);
        $result = NotificationResource::collection($notification);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\NotificationRequest $request
     * @return  \Illuminate\Http\Response
     * @param  Request $request
     * @return  Response
     *
     *  @OA\Post(
     *      path="/api/admin/notification",
     *      tags={"Notification"},
     *      operationId="storeNotification",
     *      summary="Create Notification",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/notification"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/notification",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(CreateNotificationRequest $request, Notification $notification)
    {
        try {
            $params = $request->all();
            $notification = $this->notificationService->create($params);
            $result = new NotificationResource($notification);

            return response()->success(
                self::STORE,
                $result,
                self::MESSAGE_NOTIFY_CREATE_SUCCESS,
                self::CODE_SUCCESS_201
            );
        } catch (\Exception $e) {
            return response()->failure(
                self::STORE,
                self::MESSAGE_NOTIFY_CREATE_ERROR,
                self::MESSAGE_NOTIFY_CREATE_ERROR,
                self::CODE_ERROR_400
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/notification/{id}",
     *      tags={"Notification"},
     *      operationId="showNotification",
     *      summary="Get Notification",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/notification",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show(Notification $notification)
    {
        $notification = $this->notificationService->show($notification);
        $result = new NotificationResource($notification);

        return response()->success(self::STORE, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NotificationRequest $request
     * @param  \App\Models\Notification  $notification
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/admin/notification/{id}",
     *      tags={"Notification"},
     *      operationId="updateNotification",
     *      summary="Update Notification",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/notification"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/notification",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        try {
            $params = $request->all();
            $this->notificationService->update($notification, $params);
            $result = new NotificationResource($notification);

            return response()->success(
                self::UPDATE,
                $result,
                self::MESSAGE_NOTIFY_UPDATE_SUCCESS,
                self::CODE_SUCCESS_201
            );
        } catch (\Exception $e) {
            return response()->failure(
                self::UPDATE,
                self::MESSAGE_NOTIFY_UPDATE_ERROR,
                self::MESSAGE_NOTIFY_UPDATE_ERROR,
                self::CODE_ERROR_400
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/admin/notification/{id}",
     *      tags={"Notification"},
     *      operationId="deleteNotification",N
     *      summary="Delete Notification",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Deleted",
     *      ),
     *  )
     */
    public function destroy(Request $request, Notification $notification)
    {
        try {
            $this->notificationService->delete($notification);

            return response()->success(
                self::DELETE,
                self::MESSAGE_NOTIFY_DELETE_SUCCESS,
                self::MESSAGE_NOTIFY_DELETE_SUCCESS,
                self::CODE_SUCCESS_201
            );
        } catch (\Exception $e) {
            return response()->failure(
                self::UPDATE,
                self::MESSAGE_NOTIFY_DELETE_ERROR,
                self::MESSAGE_NOTIFY_DELETE_ERROR,
                self::CODE_ERROR_400
            );
        }
    }
}
