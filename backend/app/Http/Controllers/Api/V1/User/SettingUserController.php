<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\SettingUser;
use App\Services\SettingUserService;
use App\Http\Requests\User\SettingUsers\CreateSettingUserRequest;
use App\Http\Requests\User\SettingUsers\UpdateSettingUserRequest;
use App\Http\Resources\User\SettingUsers\SettingUserResource;

/**
 *  @OA\Tag(
 *      name="Settinguser",
 *      description="SettingUser Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="settingUser",
 *      @OA\Property(
 *          property="id",
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
 *      @OA\Property(
 *          property="user_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="contract_notify",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="system_notify",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 */
class SettingUserController extends Controller
{
    /**
     * @var  App\Services\SettingUserService settingUserService
     */
    protected $settingUserService;

    public function __construct(SettingUserService $settingUserService)
    {
        // Check permission
        // $this->middleware('permission:settinguser.show', ['only' => ['show']]);
        // $this->middleware('permission:settinguser.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:settinguser.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:settinguser.destroy', ['only' => ['destroy']]);

        $this->settingUserService = $settingUserService;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SettingUser  $settingUser
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/user/setting/{id}",
     *      tags={"Settinguser"},
     *      operationId="showSettingUser",
     *      summary="Get SettingUser",
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
     *                  ref="#/components/schemas/settingUser",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show($id)
    {
        try {
            $settingUser = $this->settingUserService->findOrFail($id);
            $settingUser = $this->settingUserService->showSettingUser($settingUser);
            $result = new SettingUserResource($settingUser);

            return response()->success(self::SHOW, $result);
        } catch (\Exception $e) {
            return response()->failure(self::SHOW, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SettingUser  $settingUser
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Post(
     *      path="/api/user/setting",
     *      tags={"Settinguser"},
     *      operationId="updateOrCreateSettingUser",
     *      summary="Post SettingUser",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="contract_notify",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="system_notify",
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
     *                  ref="#/components/schemas/settingUser",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function updateOrCreate(UpdateSettingUserRequest $request)
    {
        $settingUser = $this->settingUserService->updateOrCreateSettingUser($request);
        $result = new SettingUserResource($settingUser);

        return response()->success(self::UPDATE, $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SettingUser  $settingUser
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/user/setting/get-by-user-id",
     *      tags={"Settinguser"},
     *      operationId="getSettingByUserId",
     *      summary="Get SettingByUserId",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/settingUser"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/settingUser",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function getNotification()
    {
        $auth = auth()->guard('user_api')->user()->id;

        $setting = $this->settingUserService->getNotificationByUser($auth);

        return response()->success(self::SHOW, $setting);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SettingUser  $settingUser
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/user/setting/get-by-user-id",
     *      tags={"Settinguser"},
     *      operationId="getSettingByUserId",
     *      summary="Get SettingByUserId",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/settingUser"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/settingUser",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function getByUserId(Request $request)
    {
        $user_id = $request->user_id;
        $setting = $this->settingUserService->getByUserId($user_id);
        if (!$setting) {
            return response()->success(self::SHOW, null);
        }
        $result = new SettingUserResource($setting);

        return response()->success(self::SHOW, $result);
    }
}
