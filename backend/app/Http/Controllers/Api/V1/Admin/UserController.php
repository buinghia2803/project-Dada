<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Http\Resources\Admin\Users\UserResource;

/**
 *  @OA\Tag(
 *      name="User",
 *      description="User Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="user",
 *      @OA\Property(
 *          property="id",
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
class UserController extends Controller
{
    /**
     * @var  App\Services\UserService userService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        // Check permission
        // $this->middleware('permission:user.show', ['only' => ['show']]);
        // $this->middleware('permission:user.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user.destroy', ['only' => ['destroy']]);

        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/user",
     *      tags={"User"},
     *      operationId="indexUser",
     *      summary="List User",
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
     *                  @OA\Items(ref="#/components/schemas/user")
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
        $dataCondition = [
            'limit' => self::ADMIN_PER_PAGE,
        ];
        $params = $this->userService->merge_params($request->all(), $dataCondition);
        $user = $this->userService->listUser($params);
        $result = UserResource::collection($user);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @return  \Illuminate\Http\Response
     * @param  Request $request
     * @return  Response
     *
     *  @OA\Post(
     *      path="/api/admin/user",
     *      tags={"User"},
     *      operationId="storeUser",
     *      summary="Create User",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/user"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/user",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(CreateUserRequest $request, User $user)
    {
        try {
            $params = $request->all();
            $user = $this->userService->create($params);
            $result = new UserResource($user);

            return response()->success(self::STORE, $result, self::CREATE_USER_SUCCESS, self::CODE_SUCCESS_201);
        } catch (\Exception $e) {
            return response()->failure(self::STORE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/user/{id}",
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
    public function show(User $user)
    {
        $user = $this->userService->show($user);
        $result = new UserResource($user);

        return response()->success(self::STORE, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/admin/user/{id}",
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
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->find($id);
            if (!$user) {
                return response()->failure(self::UPDATE, self::MESSAGE_USER_ERROR, self::CODE_ERROR_400, self::CODE_ERROR_400);
            }
            $params = $request->all();

            $this->userService->update($user, $params);
            $result = new UserResource($user);

            return response()->success(self::UPDATE, $result, self::UPDATE_USER_SUCCESS, self::CODE_SUCCESS_201);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/admin/user/{id}",
     *      tags={"User"},
     *      operationId="deleteUser",
     *      summary="Delete User",
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
    public function destroy($id)
    {
        $user = $this->userService->find($id);
        if (!$user) {
            return response()->failure(self::DELETE, self::MESSAGE_USER_ERROR, self::CODE_ERROR_400, self::CODE_ERROR_400);
        }
        $check = $this->userService->delete($user);
        if (isset($check['error']) && $check['error'] == 'has_contract_offer') {
            return response()->failure(self::DELETE, self::MESSAGE_CANT_DELETE, self::CODE_ERROR_400, self::CODE_ERROR_400);
        }

        return response()->success(self::DELETE, null, self::DELETE_USER_SUCCESS, self::CODE_SUCCESS_201);
    }
}
