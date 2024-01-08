<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ContractNft;
use App\Services\ContractNftService;
use App\Http\Requests\Admin\ContractNfts\CreateContractNftRequest;
use App\Http\Requests\Admin\ContractNfts\UpdateContractNftRequest;
use App\Http\Resources\Admin\ContractNfts\ContractNftResource;

/**
 *  @OA\Tag(
 *      name="ContractNft",
 *      description="ContractNft Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="contractNft",
 *      @OA\Property(
 *          property="id",
 *          type="number",
 *          example="1",
 *      ),
 *      @OA\Property(
 *          property="contractOffer",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Nguyen Van A",
 *      ),
 *      @OA\Property(
 *          property="image_url",
 *          type="string",
 *          example="https://picsum.photos/seed/picsum/200/300",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          example="This is description",
 *      ),
 *      @OA\Property(
 *          property="token_url",
 *          type="string",
 *          example="This is token url",
 *      ),
 *      @OA\Property(
 *          property="token_contract",
 *          type="string",
 *          example="This is token contract",
 *      ),
 *      @OA\Property(
 *          property="address_contract",
 *          type="number",
 *          example="This is address contract",
 *      ),
 *      @OA\Property(
 *          property="gas_fee",
 *          type="number",
 *          example="2.5",
 *      ),
 *      @OA\Property(
 *          property="status",
 *          type="number",
 *          example="1",
 *      ),
 *  )
 */
class ContractNftController extends Controller
{
    /**
     * @var  App\Services\ContractNftService contractNftService
     */
    protected $contractNftService;

    public function __construct(ContractNftService $contractNftService)
    {
        // Check permission
        // $this->middleware('permission:contractnft.show', ['only' => ['show']]);
        // $this->middleware('permission:contractnft.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:contractnft.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:contractnft.destroy', ['only' => ['destroy']]);

        $this->contractNftService = $contractNftService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/nft",
     *      tags={"ContractNft"},
     *      operationId="indexContractNft",
     *      summary="List ContractNft",
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
     *                  @OA\Items(ref="#/components/schemas/contractNft")
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
        $contractNft = $this->contractNftService->listContractNft($params);
        $result = ContractNftResource::collection($contractNft);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractNft  $contractNft
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/nft/{id}",
     *      tags={"ContractNft"},
     *      operationId="showContractNft",
     *      summary="Get ContractNft",
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
     *                  ref="#/components/schemas/contractNft",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show($id)
    {
        $contractNft = $this->contractNftService->find($id);
        if (!$contractNft) {
            return response()->failure(self::SHOW, self::MESSAGE_NOTIFY_UPDATE_ERROR, self::CODE_ERROR_400, self::CODE_ERROR_400);
        }
        $contractNft = $this->contractNftService->showContractNft($contractNft);
        $result = new ContractNftResource($contractNft);

        return response()->success(self::STORE, $result);
    }
}
