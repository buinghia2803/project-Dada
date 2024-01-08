<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Admin\AuthRequest;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Http\Resources\Admin\AdminResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\Admin\ChangePasswordRequest;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Resources\Admin\Users\UserResource;

/**
 *  @OA\Tag(
 *      name="Auth",
 *      description="Admin Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="auth",
 *      @OA\Property(
 *          property="first_name",
 *          type="string",
 *          example="admin",
 *      ),
 *      @OA\Property(
 *          property="last_name",
 *          type="string",
 *          example="admin",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="admin@admin.com",
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          example="123456",
 *      ),
 *  )
 */
class AuthController extends Controller
{
    /**
     * @var  adminService
     */
    protected $adminService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AdminService $adminService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);

        $this->adminService = $adminService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Post(
     *      path="/api/admin/login",
     *      tags={"Auth"},
     *      operationId="loginAdmin",
     *      summary="Login Admin",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="admin@admin.com"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  example="123456"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/auth",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function login(AuthRequest $request)
    {
        $params = $request->all();
        if (!auth()->guard('admin_login')->attempt($params)) {
            return response()->failure(self::LOGIN, self::MESSAGE_LOGIN_FAILD, self::CODE_ERROR_403, self::CODE_ERROR_403);
        }

        $admin = auth('admin_login')->user();
        $this->adminService->updateToken($admin);

        $result = new AdminResource($admin);

        return response()->success(self::INDEX, $result);
    }


    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $auth = auth()->guard('admin_api')->user()->token()->revoke();
        if (!$auth) {
            return response()->failure(self::LOGOUT, self::MESSAGE_LOGIN_FAILD, self::CODE_ERROR_401, self::CODE_ERROR_401);
        }

        return response()->success(self::LOGOUT, $data = null);
    }


    /**
     * Change PassWord
     *
     * @param  mixed $request
     * @return void
     */
    public function changePassWord(ChangePasswordRequest $request)
    {
        try {
            $user = auth()->guard('admin_api')->user();

            if (Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);

                return response()->success(self::UPDATE, $user, self::MESSAGE_CHANGE_PASSWORD_SUCCESS, self::CODE_SUCCESS_201);
            } else {
                return response()->failure(
                    self::CHANGE_PASSWORD,
                    self::OLD_PASSWORD_NOT_MATCHED,
                    self::OLD_PASSWORD_NOT_MATCHED,
                    self::CODE_ERROR_403
                );
            }
        } catch (\Exception $e) {
            return response()->failure(
                self::CHANGE_PASSWORD,
                self::REQUEST_WRONG,
                self::REQUEST_WRONG,
                self::CODE_ERROR_403
            );
        }
    }

    /**
     * Register a Admin.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     *  @OA\Post(
     *      path="/api/admin/register",
     *      tags={"Auth"},
     *      operationId="registerAdmin",
     *      summary="Register Admin",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/auth"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/auth",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function register(CreateUserRequest $request)
    {

        $params = $request->all();
        $params['password'] = bcrypt($request->password);
        $user = $this->userService->create($params);
        $result = new UserResource($user);

        return response()->success(self::STORE, $result);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth('web')->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->success(self::PROFILE, auth()->guard('admin_api')->user());
    }
}
