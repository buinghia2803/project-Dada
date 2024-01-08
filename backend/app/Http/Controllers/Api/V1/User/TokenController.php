<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Services\TokenService;
use App\Http\Requests\User\Tokens\CreateTokenRequest;
use App\Http\Requests\User\Tokens\UpdateTokenRequest;
use App\Http\Resources\User\Tokens\TokenResource;

/**
 *  @OA\Tag(
 *      name="token",
 *      description="Token Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="Token",
 *      @OA\Property(
 *          property="id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="id_artist",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="token_contract_offer",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="token_confirm",
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
class TokenController extends Controller
{
    /**
     * @var  App\Services\TokenService tokenService
     */
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        // Check permission
        // $this->middleware('permission:token.show', ['only' => ['show']]);
        // $this->middleware('permission:token.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:token.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:token.destroy', ['only' => ['destroy']]);

        $this->tokenService = $tokenService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/token",
     *      tags={"Token"},
     *      operationId="indexToken",
     *      summary="List Token",
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
     *                  @OA\Items(ref="#/components/schemas/token")
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
        $token = $this->tokenService->listToken($params);
        if(!$token){
            return response()->failure(self::CONFIRM_TOKEN, self::NOT_FOUND, self::CODE_ERROR_400, self::CODE_ERROR_400);
        }
        $result = TokenResource::collection($token);
        
        return response()->success(self::INDEX, $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TokenRequest $request
     * @return  \Illuminate\Http\Response
     *
     * @param  Request $request
     * @return  Response
     *
     *  @OA\Post(
     *      path="/api/token",
     *      tags={"Token"},
     *      operationId="storeToken",
     *      summary="Create Token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/token"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/token",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(CreateTokenRequest $request, Token $token)
    {
        try {
            $params = $request->all();
            $token = $this->tokenService->create($params);

            if (!empty($token)) {
                $result = new TokenResource($token);
            } else {
                return response()->failure(self::CHECK_TOKEN_CONTRACT_OFFER_FAILD, self::NOT_FOUND, self::CODE_ERROR_400, self::CODE_ERROR_400);
            }

            return response()->success(self::STORE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::STORE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Token  $token
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/token/{id}",
     *      tags={"Token"},
     *      operationId="deleteToken",
     *      summary="Delete Token",
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
    public function destroy(Request $request, Token $token)
    {
        //$params = $request->all();
        $this->tokenService->delete($token);

        return response()->success(self::DELETE);
    }
}
