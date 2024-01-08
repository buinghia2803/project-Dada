<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 *  @OA\OpenApi(
 *      security={
 *          {"bearerAuth": {}}
 *      }
 *  )
 *
 *  @OA\Info(
 *      description="Relipa API Document",
 *      version="1.0.0",
 *      title="API",
 *  )
 *
 *  @OA\PathItem(path="/api")
 *
 *  @OA\SecurityScheme(
 *      type="http",
 *      in="header",
 *      securityScheme="bearerAuth",
 *      scheme="bearer"
 *  )
 *
 *  @OA\Parameter(
 *      name="page",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="limit",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="sort",
 *      in="query",
 *  )
 *
 *  @OA\Parameter(
 *      name="sortType",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="condition",
 *      in="query",
 *  )
 *
 *    @OA\Schema(
 *      schema="meta",
 *      @OA\Property(
 *          property="current_page",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="from",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="last_page",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="path",
 *          type="string",
 *          example="http://abc.com",
 *      ),
 *      @OA\Property(
 *          property="per_page",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="to",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="total",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 *
 *  @OA\Schema(
 *      schema="links",
 *      @OA\Property(
 *          property="first",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="last",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="prev",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="next",
 *          type="number",
 *          example=1,
 *      )
 *  )
 *
 *  @OA\Schema(
 *      schema="empty"
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Action system
    const LOGIN = 'login';
    const LOGOUT = 'logout';
    const PROFILE = 'profile';
    const INDEX = 'index';
    const SHOW = 'show';
    const DETAIL = 'detail';
    const CREATE = 'create';
    const STORE = 'store';
    const UPDATE = 'update';
    const UPDATE_STATUS = 'update_status';
    const REMOVE = 'remove';
    const DELETE = 'delete';
    const COMMENT = 'comment';
    const REJECT = 'reject';
    const CONFIRM = 'confirm';
    const COUNT = 'count';
    const DUPLICATE_EMAIL = 'duplicate email';
    const DUPLICATE_NAME = 'duplicate name';
    const CHANGE_PASSWORD = 'change password';
    const FORGOT_PASSWORD = 'forgot password';
    const SEND_MAIL_TO_ARTIST = 'send mail to artist';
    const DAD_INFORMATION = 'dad information';
    const GET_CONTRACT_OFFER_BY_TOKEN = 'contract offer token';
    const CHECK_TOKEN_CONTRACT_OFFER_FAILD = 'check token faild';
    const CONFIRM_TOKEN = 'check token confirm';

    // System success code
    const CODE_SUCCESS_200 = 200;
    const CODE_SUCCESS_201 = 201;
    const CODE_SUCCESS_203 = 203;
    const CODE_SUCCESS_204 = 204;

    // System error code
    const CODE_ERROR_400 = 400;
    const CODE_ERROR_401 = 401;
    const CODE_ERROR_403 = 403;
    const CODE_ERROR_404 = 404;

    const STATUS_USER_NOT_ACTIVE = 0; //not active/lock
    const STATUS_USER_ACTIVE = 1; //active
    const STATUS_USER_DELETE = 2;

    // Message response
    const NOT_FOUND = 'Not found';
    const MESSAGE_LOGIN_FAILD = 'メールアドレスまたはパスワードが正しくありません。';
    const MESSAGE_LOGIN_USER_FAIL = 'Account does not exist or is locked';
    const DUPLICATE_EMAIL_MESSAGE = 'Email already exists';
    const OLD_PASSWORD_NOT_MATCHED = '現在パスワードが正しくありません。';
    const REQUEST_WRONG = "エラーが発生しました。再度お試しください。";

    //Change password
    const MESSAGE_CHANGE_PASSWORD_SUCCESS = "パスワードの変更に成功しました。";
    //Change password

    //Forgot password
    const MESSAGE_FORGOT_PASSWORD_SUCCESS = "登録いただいたメールアドレスへパスワード再設定リンクを送信しました。";
    const MESSAGE_FORGOT_PASSWORD2_SUCCESS = "パスワード再設定用リンクの有効期限が切れています。もう一度やり直してください。";
    const MESSAGE_FORGOT_PASSWORD_ERROR = "エラーが発生しました。再度ご入力ください。";
    //forgot password

    //Message Admin Mail Template
    const MESSAGE_MAIL_TEMPLATE_UPDATE_SUCCESS = 'メールテンプレートの更新は成功しました！';

    //Message Admin notify
    const MESSAGE_NOTIFY_UPDATE_SUCCESS = '通知の作成に成功しました。';
    const MESSAGE_NOTIFY_UPDATE_ERROR = 'エラーが発生しました。再度お試しください。。';
    const MESSAGE_NOTIFY_CREATE_SUCCESS = '通知の作成に成功しました。';
    const MESSAGE_NOTIFY_CREATE_ERROR = 'エラーが発生しました。再度お試しください。';
    const MESSAGE_NOTIFY_DELETE_ERROR = 'エラーが発生しました。再度お試しください。';
    const MESSAGE_NOTIFY_DELETE_SUCCESS = '通知の削除に成功しました。';
    //Message Admin notify


    const MAIL_NOT_REGISTERED = 'メールアドレスが存在しません。';
    const MAIL_NOT_REGISTERED_OR_NOT_MAIL = 'メールアドレスが存在しません。';
    const MAIL_NOT_CONTRACT_OFFER_OR_NOT_MAIL = 'This contract offer does not exist or mail does not exist';
    const MAIL_TEMPLATES_PASSWORD_RESET = 3;
    const MAIL_TEMPLATES_SEND_TO_ARTIST = 6;

    const ADMIN_PER_PAGE = 10;

    const CREATE_USER_SUCCESS = 'ユーザーの作成に成功しました。';
    const UPDATE_USER_SUCCESS = 'ユーザーの更新に成功しました。';
    const DELETE_USER_SUCCESS = 'ユーザーの削除に成功しました。';
    const MESSAGE_USER_ERROR = 'エラーが発生しました。再度お試しください。';
    const DELETE_USER_ERROR = 'ユーザーの削除に失敗しました。';
    const MESSAGE_CANT_DELETE = 'このユーザーにはオファーがあるため削除できません。';

    const MESSAGE_UPDATE_PROFILE_SUCCESS = '更新しました。';

    const MESSAGE_SETTING_UPDATE_SUCCESS = 'データの更新に成功しました。';
    const MESSAGE_SETTING_ERROR = 'エラーが発生しました。再度お試しください。';

    const NOT_SEEN = 0;
    const WATCHED = 1;

    const DECIMAL = 0.01;
    const SETTING_ID = 1;

    //Message Admin Payment
    const MESSAGE_PAYMENT_UPDATE_SUCCESS = '支払いの更新に成功しました。';
    const MESSAGE_PAYMENT_UPDATE_ERROR = 'エラーが発生しました。再度お試しください。';

    const DESC = 'DESC';
    const ASC = 'ASC';
}
