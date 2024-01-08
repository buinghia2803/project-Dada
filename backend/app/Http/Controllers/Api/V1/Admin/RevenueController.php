<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RevenueService;
use App\Http\Resources\Admin\Revenue\RevenueResource;

/**
 *  @OA\Tag(
 *      name="revenue",
 *      description="Revenue Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="Revenue",
 *  )
 */
class RevenueController extends Controller
{
    /**
     * @var  App\Services\RevenueService revenueService
     */
    protected $revenueService;

    public function __construct(RevenueService $revenueService)
    {
        // Check permission
        // $this->middleware('permission:revenue.show', ['only' => ['show']]);
        // $this->middleware('permission:revenue.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:revenue.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:revenue.destroy', ['only' => ['destroy']]);

        $this->revenueService = $revenueService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/revenue",
     *      tags={"Revenue"},
     *      operationId="indexRevenue",
     *      summary="List Revenue",
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
     *                  @OA\Items(ref="#/components/schemas/revenue")
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
        $revenue = $this->revenueService->sumDataRevenue($params);

        return response()->success(self::INDEX, $revenue);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/revenue/by-list-user",
     *      tags={"Revenue"},
     *      operationId="indexRevenue",
     *      summary="List Revenue",
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
     *                  @OA\Items(ref="#/components/schemas/revenue")
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
    public function sumDataByUser(Request $request)
    {
        $params = $request->all();
        $revenue = $this->revenueService->sumListDataUserRevenue($params);
        $result = RevenueResource::collection($revenue);

        return response()->success(self::INDEX, $result);
    }
}
