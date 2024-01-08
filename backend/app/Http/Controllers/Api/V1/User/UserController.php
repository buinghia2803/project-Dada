<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\User\Users\CreateUserRequest;
use App\Http\Requests\User\Users\UpdateUserRequest;
use App\Http\Resources\User\Users\UserResource;
use App\Services\Upload\UploadService;
use App\Http\Controllers\Api\V1\UploadFileController;

/**
 *  @OA\Tag(
 *      name="user",
 *      description="User Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="User",
 *      @OA\Property(
 *          property="contract_address",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="full_name",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="image_url",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="positions",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="public_address_main",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="public_address_sub",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="type",
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
class UserController extends Controller
{
    /**
     * @var  App\Services\UserService userService
     */
    protected $userService;
    protected $uploadService;

    public function __construct(UserService $userService, UploadService $uploadService)
    {
        // Check permission
        // $this->middleware('permission:user.show', ['only' => ['show']]);
        // $this->middleware('permission:user.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user.destroy', ['only' => ['destroy']]);

        $this->userService = $userService;
        $this->uploadService = $uploadService;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/user/{id}",
     *      tags={"User"},
     *      operationId="showUser",
     *      summary="Get User",
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
     *                  ref="#/components/schemas/user",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function profile($id)
    {
        $findUser = $this->userService->find($id);
        if (!$findUser) {
            return response()->failure(
                self::PROFILE,
                self::NOT_FOUND,
                self::CODE_SUCCESS_204,
                self::CODE_SUCCESS_204
            );
        }
        $profile = $this->userService->show($findUser);
        $result = new UserResource($profile);

        return response()->success(self::PROFILE, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/user/{id}",
     *      tags={"User"},
     *      operationId="updateUser",
     *      summary="Update User",
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
     *          @OA\JsonContent(ref="#/components/schemas/user"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/user",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function updateProfile(UpdateUserRequest $request)
    {
        try {
            $auth = auth()->guard('user_api')->user();
            $user = $this->userService->find($auth->id);
            if (!$user) {
                return response()->failure(
                    self::PROFILE,
                    self::MESSAGE_USER_ERROR,
                    self::CODE_ERROR_400,
                    self::CODE_ERROR_400
                );
            }
            $this->userService->editProfile($user, $request);
            $result = new UserResource($user);

            return response()->success(self::PROFILE, $result, self::MESSAGE_UPDATE_PROFILE_SUCCESS, self::CODE_SUCCESS_201);
        } catch (\Exception $e) {
            return $e;
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    public function show($id)
    {
        $user = $this->userService->show($id);
        $result = new UserResource($user);

        return response()->success(self::STORE, $result);
    }
}
