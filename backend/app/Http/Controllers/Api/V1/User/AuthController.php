<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\Users\UserResource;
use App\Http\Resources\User\Users\DadInformationResource;
use App\Models\User;
use App\Services\Upload\UploadService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
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

    public function updateType(Request $request)
    {
        try {
            $params = $request->all();
            $user = User::where('id', $params['id'])->first();
            $user_result = $this->userService->update($user, $params);
            $result = new UserResource($user_result);

            return response()->success(self::UPDATE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    public function loginUser(Request $request)
    {
        $params = $request->all();
        $user = User::where('public_address_main', $params['public_address_main'])->first();
        if (!$user) {
            $user = User::create([
                'public_address_main' => $params['public_address_main'],
                'full_name' => 'user name',
                'type' => 1,
                'status' => 1
            ]);
        } else {
            if ($user->status != self::STATUS_USER_ACTIVE) {
                return response()->failure(self::LOGIN, self::MESSAGE_LOGIN_FAILD, self::CODE_ERROR_403, self::CODE_ERROR_403);
            }
        }
        $user->access_token = $user->createToken($user->public_address_main)->accessToken;
        return response()->success(self::INDEX, $user);
    }

    public function userProfile()
    {
        return response()->success(self::PROFILE, auth()->guard('user_api')->user());
    }

    public function dadInformation()
    {
        $dad = $this->userService->findByUserId();
        $result = new DadInformationResource($dad);

        return response()->success(self::DAD_INFORMATION, $result);
    }

    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $auth = auth()->guard('user_api')->user()->token()->revoke();
        if (!$auth) {
            return response()->failure(self::LOGOUT, self::MESSAGE_LOGIN_FAILD, self::CODE_ERROR_401, self::CODE_ERROR_401);
        }

        return response()->success(self::LOGOUT, $data = null);
    }
}
