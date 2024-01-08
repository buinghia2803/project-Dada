<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\NotificationUser;
use App\Services\NotificationUserService;
use App\Http\Requests\User\NotificationUsers\CreateNotificationUserRequest;
use App\Http\Requests\User\NotificationUsers\UpdateNotificationUserRequest;
use App\Http\Resources\User\NotificationUsers\NotificationUserResource;

/**
 *  @OA\Tag(
 *      name="Notificationuser",
 *      description="NotificationUser Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="notificationuser",
 *      @OA\Property(
 *          property="id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="notification_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="admin_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="user_from",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="user_to",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 */
class NotificationUserController extends Controller
{
    /**
     * @var  App\Services\NotificationUserService notificationUserService
     */
    protected $notificationUserService;

    public function __construct(NotificationUserService $notificationUserService)
    {
        // Check permission
        // $this->middleware('permission:notificationuser.show', ['only' => ['show']]);
        // $this->middleware('permission:notificationuser.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:notificationuser.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:notificationuser.destroy', ['only' => ['destroy']]);

        $this->notificationUserService = $notificationUserService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/notification-user",
     *      tags={"NotificationUser"},
     *      operationId="indexNotificationUser",
     *      summary="List NotificationUser",
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
     *                  @OA\Items(ref="#/components/schemas/notificationuser")
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
        $notificationUser = $this->notificationUserService->listNotificationUser($params);
        $result = NotificationUserResource::collection($notificationUser);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NotificationUserRequest $request
     * @param  \App\Models\NotificationUser  $notificationUser
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/notification-user/{id}",
     *      tags={"NotificationUser"},
     *      operationId="updateNotificationUser",
     *      summary="Update NotificationUser",
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
     *          @OA\JsonContent(ref="#/components/schemas/notificationuser"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/notificationuser",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(UpdateNotificationUserRequest $request, NotificationUser $notificationUser)
    {
        try {
            $watched = self::WATCHED;

            $params = $this->notificationUserService->merge_params($request, $watched);

            $this->notificationUserService->update($notificationUser, $params);
            $result = new NotificationUserResource($notificationUser);

            return response()->success(self::UPDATE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\NotificationUserRequest $request
     * @param  \App\Models\NotificationUser  $notificationUser
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/notification-user/{id}",
     *      tags={"NotificationUser"},
     *      operationId="updateNotificationUser",
     *      summary="Update NotificationUser",
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
     *          @OA\JsonContent(ref="#/components/schemas/notificationuser"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/notificationuser",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function updateStatusNotificationUser(Request $request)
    {
        try {
            $params = $request->all();

            $this->notificationUserService->updateStatusNotify($params);

            return response()->success(self::UPDATE, null);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }
}
