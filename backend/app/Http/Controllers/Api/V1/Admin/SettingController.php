<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use App\Http\Requests\Admin\Settings\CreateSettingRequest;
use App\Http\Requests\Admin\Settings\UpdateSettingRequest;
use App\Http\Resources\Admin\Settings\SettingResource;

/**
 *  @OA\Tag(
 *      name="Setting",
 *      description="Setting Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="setting",
 *      @OA\Property(
 *          property="created_at",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="currency_eth",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="opensea_percent",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="system_percent",
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
class SettingController extends Controller
{
    /**
     * @var  App\Services\SettingService settingService
     */
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        // Check permission
        // $this->middleware('permission:setting.show', ['only' => ['show']]);
        // $this->middleware('permission:setting.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:setting.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:setting.destroy', ['only' => ['destroy']]);

        $this->settingService = $settingService;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Post(
     *      path="/api/admin/setting",
     *      tags={"Setting"},
     *      operationId="updateOrCreateSetting",
     *      summary="Post Setting",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="system_percent",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="opensea_percent",
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
     *                  ref="#/components/schemas/setting",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function updateOrCreate(UpdateSettingRequest $request)
    {
        try {
            $settingAdmin = $this->settingService->updateOrCreateSetting($request);
            $result = new SettingResource($settingAdmin);

            return response()->success(self::UPDATE, $result, self::MESSAGE_SETTING_UPDATE_SUCCESS, self::CODE_SUCCESS_201);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, self::MESSAGE_SETTING_ERROR, self::CODE_ERROR_400, self::CODE_ERROR_400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SettingUser  $settingUser
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/setting",
     *      tags={"Settinguser"},
     *      operationId="showSettingAdmin",
     *      summary="Get SettingAdmin",
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
     *                  ref="#/components/schemas/setting",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $settingAdmin = $this->settingService->listSetting($params);
        if (!$settingAdmin) {
            return response()->success(self::INDEX, null);
        }
        $result = new SettingResource($settingAdmin);

        return response()->success(self::INDEX, $result);
    }
}
