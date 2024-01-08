<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Jobs\SendMailTemplate;
use App\Http\Requests\Auth\Admin\PasswordResetRequest;

/**
 *  @OA\Tag(
 *      name="Admin",
 *      description="Admin Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="admin",
 *  )
 */
class AdminController extends Controller
{

    /**
     * @var  AdminService
     */
    protected $adminService;

    public function __construct(
        AdminService $adminService
    )
    {
        $this->adminService = $adminService;
    }

    /**
     * Send mail reset password.
     *
     *  @OA\Get(
     *      path="/api/admin/generate-link",
     *      tags={"Admin"},
     *      operationId="getGenerateLinkResetPW",
     *      summary="getGenerateLinkResetPW",
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="An authorization code has been sent to your email address."
     *                  )
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="This e-mail address is not registered."
     *                  )
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function getGenerateLinkResetPW(Request $request)
    {
        $admin = $this->adminService->getActiveUserByEmail($request->email);

        if (!$admin) {
            return response()->failure(
                self::FORGOT_PASSWORD,
                self::MAIL_NOT_REGISTERED,
                self::MAIL_NOT_REGISTERED,
                self::CODE_ERROR_403
            );
        }

        $token = $this->adminService->createResetToken($request->email, $admin);
        $link = config('constant.client_domain') . '/admin/auth/reset-password?email=' . $request->email . '&token=' . $token;
        SendMailTemplate::dispatch(self::MAIL_TEMPLATES_PASSWORD_RESET, $request->email, ['forgot_password_url' => $link]);

        return response()->success(
            self::FORGOT_PASSWORD,
            $data = null,
            self::MESSAGE_FORGOT_PASSWORD_SUCCESS,
            self::CODE_SUCCESS_201
        );
    }

    /**
     * Check token for password reset.
     *
     *  @OA\Post(
     *      path="/api/admin/check-token",
     *      tags={"Admin"},
     *      operationId="checkToken",
     *      summary="checkToken",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="admin@gmail.com"
     *              ),
     *              @OA\Property(
     *                  property="token",
     *                  type="string",
     *                  example="CYNY58UUSZ"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      description="1: Successfull, 0: Failure",
     *                      example=1
     *                  )
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="Bad request"
     *                  )
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function checkToken(Request $request)
    {
        try {
            $exist = $this->adminService->checkToken($request->token, $request->email);
            $time = strtotime(date('Y-m-d H:i:s'));
            $reset_create = strtotime($exist->created_at);
            if ($time - $reset_create > config('constant.time_limit_reset_pass')) {
                return response()->failure(
                    self::FORGOT_PASSWORD,
                    self::MAIL_NOT_REGISTERED_OR_NOT_MAIL,
                    self::CODE_ERROR_403,
                    self::CODE_ERROR_403
                );
            }
            if ($exist) {
                return response()->success(self::FORGOT_PASSWORD, $data = null);
            } else {
                return response()->failure(
                    self::FORGOT_PASSWORD,
                    self::MAIL_NOT_REGISTERED_OR_NOT_MAIL,
                    self::CODE_ERROR_403,
                    self::CODE_ERROR_403
                );
            }
        } catch (\Exception $e) {
            return response()->failure(
                self::FORGOT_PASSWORD,
                self::MESSAGE_FORGOT_PASSWORD_ERROR,
                self::MESSAGE_FORGOT_PASSWORD_ERROR,
                self::CODE_ERROR_403
            );
        }
    }

    /**
     * Reset password.
     *
     *  @OA\Post(
     *      path="/api/admin/password-reset",
     *      tags={"Admin"},
     *      operationId="passwordReset",
     *      summary="passwordReset",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/admin"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="password_confirmation",
     *                          type="string",
     *                          example="123456789",
     *                      ),
     *                      @OA\Property(
     *                          property="token",
     *                          type="string",
     *                          example="DF7END2BNC",
     *                      ),
     *                  )
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="status",
     *                      type="integer",
     *                      description="1: Successfull, 0: Failure",
     *                      example=1
     *                  )
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Logged in",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="message",
     *                      type="string",
     *                      example="Bad request"
     *                  )
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function passwordReset(PasswordResetRequest $request)
    {
        try {
            $result = $this->adminService->passwordReset($request->only('token', 'password'));
            if ($result) {
                $this->adminService->deleteSecretKey($request->token);
                return response()->success(
                    self::FORGOT_PASSWORD,
                    $data = null,
                    self::MESSAGE_CHANGE_PASSWORD_SUCCESS,
                    self::CODE_SUCCESS_201
                );
            } else {
                return response()->failure(
                    self::FORGOT_PASSWORD,
                    self::MESSAGE_FORGOT_PASSWORD_ERROR,
                    self::CODE_ERROR_403,
                    self::CODE_ERROR_403
                );
            }
        } catch (\Exception $e) {
            return response()->failure(
                self::FORGOT_PASSWORD,
                $data = null,
                self::MESSAGE_FORGOT_PASSWORD_ERROR,
                self::CODE_ERROR_400
            );
        }
    }
}
