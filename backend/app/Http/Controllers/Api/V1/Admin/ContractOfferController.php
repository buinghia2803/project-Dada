<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ContractOffer;
use App\Services\ContractOfferService;
use App\Http\Requests\Admin\ContractOffers\CreateContractOfferRequest;
use App\Http\Requests\Admin\ContractOffers\UpdateContractOfferRequest;
use App\Http\Resources\Admin\ContractOffers\ContractOfferResource;

/**
 *  @OA\Tag(
 *      name="ContractOffer",
 *      description="ContractOffer Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="contractOffer",
 *      @OA\Property(
 *          property="id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="dad_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="artist_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="date_start",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="date_end",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="selling_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="dad_percent",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="artist_percent",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="dad_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="artist_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="system_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="opensea_price",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="system_percent",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="opensea_percent",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="responsibility",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="contact_info",
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
class ContractOfferController extends Controller
{
    /**
     * @var  App\Services\ContractOfferService contractOfferService
     */
    protected $contractOfferService;

    public function __construct(ContractOfferService $contractOfferService)
    {
        // Check permission
        // $this->middleware('permission:contractoffer.show', ['only' => ['show']]);
        // $this->middleware('permission:contractoffer.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:contractoffer.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:contractoffer.destroy', ['only' => ['destroy']]);

        $this->contractOfferService = $contractOfferService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/offer",
     *      tags={"ContractOffer"},
     *      operationId="indexContractOffer",
     *      summary="List ContractOffer",
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
     *                  @OA\Items(ref="#/components/schemas/contractOffer")
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
        $contractOffer = $this->contractOfferService->listContractOffer($params);
        $result = ContractOfferResource::collection($contractOffer);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractOffer  $contractOffer
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/offer/{id}",
     *      tags={"ContractOffer"},
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
     *                  ref="#/components/schemas/contractOffer",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show($id)
    {
        $contractOffer = $this->contractOfferService->find($id);
        if (!$contractOffer) {
            return response()->failure(self::SHOW, self::MESSAGE_NOTIFY_UPDATE_ERROR, self::CODE_ERROR_400, self::CODE_ERROR_400);
        }
        $contractOffer = $this->contractOfferService->showContractOffer($contractOffer);
        $result = new ContractOfferResource($contractOffer);

        return response()->success(self::STORE, $result);
    }
}
