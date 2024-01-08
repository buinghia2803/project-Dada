<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Resources\Admin\ContractNfts\ContractNftResource;
use App\Services\ContractNftService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContractNftUser\UpdateContractNftUserRequest;
use App\Http\Requests\User\ContractNftUser\CreateContractNftUserRequest;
use App\Http\Resources\Admin\ContractNfts\ContractNftCreateResource;
use App\Models\ContractNft;

/**
 *  @OA\Tag(
 *      name="ContractNftUser",
 *      description="Contract Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="contractNftUser",
 *      @OA\Property(
 *          property="contract_offer_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="image_url",
 *          type="string",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="token_url",
 *          type="string",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="address_contract",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="token_contract",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="gas_fee",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="status",
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
class ContractNftController extends Controller
{
    /**
     * @var  App\Services\ContractNftService contractOfferService
     */
    protected $contractOfferService;

    public function __construct(ContractNftService $contractNftService)
    {
        // Check permission
        // $this->middleware('permission:contractoffer.show', ['only' => ['show']]);
        // $this->middleware('permission:contractoffer.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:contractoffer.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:contractoffer.destroy', ['only' => ['destroy']]);

        $this->contractNftService = $contractNftService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/contract-nft/user/{id}",
     *      tags={"ContractNftUser"},
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
     *                  @OA\Items(ref="#/components/schemas/contractNftUser")
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

    public function listByUser($id, Request $request)
    {
        $params = $request->all();
        $contractNft = $this->contractNftService->listContractNftByUser($id, $params);
        $result = ContractNftResource::collection($contractNft);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ContractNftRequest $request
     * @param  \App\Models\ContractNft  $contractNft
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/admin/contract-nft/user/{id}",
     *      tags={"ContractNftUser"},
     *      operationId="updateContractNft",
     *      summary="Update ContractNft",
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
     *          @OA\JsonContent(ref="#/components/schemas/contractNftUser"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/contractNftUser",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(UpdateContractNftUserRequest $request, ContractNft $contractNft)
    {
        try {
            $params = $request->all();
            $contractNft = $this->contractNftService->update($contractNft, $params);
            $result = new ContractNftResource($contractNft);

            return response()->success(self::UPDATE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ContractNftRequest $request
     * @return  \Illuminate\Http\Response
     * @param  Request $request
     * @return  Response
     *
     *  @OA\Post(
     *      path="/api/user/contract-nft/user",
     *      tags={"ContractNftUser"},
     *      operationId="storeContractNft",
     *      summary="Create ContractNft",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/contractNftUser"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/contractNftUser",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(CreateContractNftUserRequest $request, ContractNft $contractNft)
    {
        try {
            $params = $request->all();
            $contractNft = $this->contractNftService->create($params);
            $result = new ContractNftResource($contractNft);

            return response()->success(self::STORE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::STORE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * CreateContractNft
     *
     * @param  mixed $request
     * @param  mixed $contractNft
     * @return void
     */
    public function createContractNft(Request $request, ContractNft $contractNft)
    {
        try {
            $params = $request->all();
            $contractNft = $this->contractNftService->createContractNft($params);
            if (!$contractNft) {
                return response()->failure(self::CREATE, self::NOT_FOUND, self::CODE_ERROR_400, self::CODE_ERROR_400);
            }
            
            $result = ContractNftCreateResource::make($contractNft);

            return response()->success(self::CREATE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::CREATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }
}
