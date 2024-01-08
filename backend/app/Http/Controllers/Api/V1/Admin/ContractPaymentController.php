<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ContractPayment;
use App\Services\ContractPaymentService;
use App\Http\Requests\Admin\ContractPayments\CreateContractPaymentRequest;
use App\Http\Requests\Admin\ContractPayments\UpdateContractPaymentRequest;
use App\Http\Resources\Admin\ContractPayments\ContractPaymentResource;
use App\Http\Resources\Admin\ContractPayments\ContractPaymentListResource;

/**
 *  @OA\Tag(
 *      name="ContractPayment",
 *      description="ContractPayment Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="contractPayment",
 *      @OA\Property(
 *          property="id",
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
 *      @OA\Property(
 *          property="contract_offer_id",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="contract_nft_id",
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
 *          property="status",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 */
class ContractPaymentController extends Controller
{
    /**
     * @var  App\Services\ContractPaymentService contractPaymentService
     */
    protected $contractPaymentService;

    public function __construct(ContractPaymentService $contractPaymentService)
    {
        // Check permission
        // $this->middleware('permission:contractpayment.show', ['only' => ['show']]);
        // $this->middleware('permission:contractpayment.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:contractpayment.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:contractpayment.destroy', ['only' => ['destroy']]);

        $this->contractPaymentService = $contractPaymentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/payment",
     *      tags={"ContractPayment"},
     *      operationId="indexContractPayment",
     *      summary="List ContractPayment",
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
     *                  @OA\Items(ref="#/components/schemas/contractPayment")
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
        $constant = [
            'desc' => self::DESC,
            'asc' => self::ASC,
            'admin_per_page' => self::ADMIN_PER_PAGE
        ];

        $params = $request->all();
        $contractPayment = $this->contractPaymentService->listContractPayment($params, $constant);
        $result = ContractPaymentListResource::collection($contractPayment);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractPayment  $contractPayment
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/admin/payment/{id}",
     *      tags={"ContractPayment"},
     *      operationId="showContractPayment",
     *      summary="Get ContractPayment",
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
     *                  ref="#/components/schemas/contractPayment",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show($id)
    {
        $contractPayment = $this->contractPaymentService->find($id);
        if (!$contractPayment) {
            return response()->failure(self::SHOW, self::MESSAGE_NOTIFY_UPDATE_ERROR, self::CODE_ERROR_400, self::CODE_ERROR_400);
        }
        $contractPayment = $this->contractPaymentService->showContractPayment($contractPayment);
        $result = new ContractPaymentResource($contractPayment);

        return response()->success(self::STORE, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ContractPaymentRequest $request
     * @param  \App\Models\ContractPayment  $contractPayment
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/admin/payment/{id}",
     *      tags={"ContractPayment"},
     *      operationId="updateContractPayment",
     *      summary="Update ContractPayment",
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
     *          @OA\JsonContent(ref="#/components/schemas/contractPayment"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/contractPayment",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(UpdateContractPaymentRequest $request, $id)
    {
        try {
            $contractPayment = $this->contractPaymentService->find($id);
            if (!$contractPayment) {
                return response()->failure(
                    self::UPDATE,
                    self::MESSAGE_PAYMENT_UPDATE_ERROR,
                    self::CODE_ERROR_400,
                    self::CODE_ERROR_400
                );
            }
            $params = $request->all();
            $this->contractPaymentService->update($contractPayment, $params);

            return response()->success(
                self::UPDATE,
                $data = null,
                self::MESSAGE_PAYMENT_UPDATE_SUCCESS,
                self::CODE_SUCCESS_201
            );
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }
}
