<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Resources\Admin\ContractNfts\ContractNftResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ContractOffer;
use App\Services\ContractOfferService;
use App\Http\Requests\User\ContractOffers\CreateContractOfferRequest;
use App\Http\Requests\User\ContractOffers\UpdateContractOfferRequest;
use App\Http\Resources\User\ContractOffers\ContractOfferByToken;
use App\Http\Resources\User\ContractOffers\ContractOfferResource;
use App\Services\SendMailService;
use Illuminate\Support\Str;

/**
 *  @OA\Tag(
 *      name="Contract",
 *      description="Contract Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="contract",
 *      @OA\Property(
 *          property="artist_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="artist_percent",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="artist_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="contact_info",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="dad_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="dad_percent",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="dad_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="date_end",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="date_start",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="email",
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
 *          property="opensea_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="responsibility",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="selling_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="system_percent",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="system_price",
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
class ContractOfferController extends Controller
{
    /**
     * @var  App\Services\ContractOfferService contractOfferService
     */
    protected $contractOfferService;
    protected $sendMailService;

    public function __construct(ContractOfferService $contractOfferService, SendMailService $sendMailService)
    {
        // Check permission
        // $this->middleware('permission:contractoffer.show', ['only' => ['show']]);
        // $this->middleware('permission:contractoffer.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:contractoffer.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:contractoffer.destroy', ['only' => ['destroy']]);

        $this->contractOfferService = $contractOfferService;
        $this->sendMailService = $sendMailService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/user/contract/user",
     *      tags={"Contract"},
     *      operationId="indexContract",
     *      summary="List Contract",
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
     *                  @OA\Items(ref="#/components/schemas/contract")
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
    public function index($id, Request $request)
    {
        $params = $request->all();
        $contractOffer = $this->contractOfferService->listContract($id, $params);
        $result = ContractOfferResource::collection($contractOffer);

        return response()->success(self::INDEX, $result);
    }

    /**
     * GetContractOfferByToken
     *
     * @param  mixed $request
     * @return void
     */
    public function getContractOfferByToken(Request $request)
    {
        $token = $request->token;
        $contractOffer = $this->contractOfferService->getContractOfferByToken($token);
        if (empty($contractOffer)) {
            return response()->failure(self::GET_CONTRACT_OFFER_BY_TOKEN, self::NOT_FOUND, self::CODE_ERROR_400, self::CODE_ERROR_400);
        }
        $result = ContractOfferByToken::make($contractOffer);
        return response()->success(self::INDEX, $result);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ContractOfferRequest $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Post(
     *      path="/api/contract-offer",
     *      tags={"ContractOffer"},
     *      operationId="storeContractOffer",
     *      summary="Create ContractOffer",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/contractoffer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/contractoffer",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(CreateContractOfferRequest $request)
    {
        try {
            $params = $request->all();
            $typeSix = self::MAIL_TEMPLATES_SEND_TO_ARTIST;
            $contractOffer = $this->contractOfferService->createContract($params, self::DECIMAL, self::SETTING_ID, $typeSix);

            if (!$contractOffer) {
                return response()->failure(
                    self::CREATE,
                    self::MESSAGE_ERROR,
                    self::CODE_ERROR_400,
                    self::CODE_ERROR_400
                );
            }

            $result = new ContractOfferResource($contractOffer);

            return response()->success(self::STORE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::STORE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractOffer  $contractOffer
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/user/contract/{id}",
     *      tags={"Contract"},
     *      operationId="showContractOffer",
     *      summary="Get ContractOffer",
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
     *                  ref="#/components/schemas/contract",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show(ContractOffer $contractOffer)
    {
        $contractOffer = $this->contractOfferService->showContractOffer($contractOffer);
        $result = new ContractOfferResource($contractOffer);

        return response()->success(self::STORE, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ContractOfferRequest $request
     * @param  \App\Models\ContractOffer  $contractOffer
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/contract-offer/{id}",
     *      tags={"ContractOffer"},
     *      operationId="updateContractOffer",
     *      summary="Update ContractOffer",
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
     *          @OA\JsonContent(ref="#/components/schemas/contractoffer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/contractoffer",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(UpdateContractOfferRequest $request, ContractOffer $contractOffer)
    {
        try {
            $params = $request->all();
            $this->contractOfferService->updateContract($contractOffer, $params, self::DECIMAL, self::SETTING_ID);
            $result = new ContractOfferResource($contractOffer);

            return response()->success(self::UPDATE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractOffer  $contractOffer
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/contract-offer/{id}",
     *      tags={"ContractOffer"},
     *      operationId="deleteContractOffer",
     *      summary="Delete ContractOffer",
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
    public function destroy(Request $request, ContractOffer $contractOffer)
    {
        //$params = $request->all();
        $this->contractOfferService->delete($contractOffer);

        return response()->success(self::DELETE);
    }

    public function sendMailToArtist(Request $request)
    {
        $params = $request->all();
        $this->contractOfferService->updateEmail($params);

        return response()->success(self::SEND_MAIL_TO_ARTIST, $data = null);
    }

    public function checkOfferEmail(Request $request)
    {
        try {
            $exist = $this->contractOfferService->checkOfferEmail($request->id, $request->email);
            if ($exist) {
                return response()->success(self::SEND_MAIL_TO_ARTIST, $data = null);
            } else {
                return response()->failure(
                    self::SEND_MAIL_TO_ARTIST,
                    self::MAIL_NOT_CONTRACT_OFFER_OR_NOT_MAIL,
                    self::CODE_SUCCESS_204,
                    self::CODE_SUCCESS_204
                );
            }
        } catch (\Exception $e) {
            return response()->failure($e->getMessage(), self::CODE_ERROR_400);
        }
    }

    public function listByUser(Request $request)
    {
        $constant = [
            'desc' => self::DESC,
            'asc' => self::ASC,
            'admin_per_page' => self::ADMIN_PER_PAGE,
        ];
        $params = $request->all();
        $contractOffer = $this->contractOfferService->listContractOfferByUser($params, $constant);
        $result = ContractOfferResource::collection($contractOffer);

        return response()->success(self::INDEX, $result);
    }
}
