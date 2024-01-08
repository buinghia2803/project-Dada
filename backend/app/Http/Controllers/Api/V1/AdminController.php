<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Services\AdminService;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Resources\Admin\Users\AdminResource;

/**
 *  @OA\Tag(
 *      name="Admin",
 *      description="Admin Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="Admin",
 *      @OA\Property(
 *          property="first_name",
 *          type="string",
 *          example="admin",
 *      ),
 *      @OA\Property(
 *          property="last_name",
 *          type="string",
 *          example="admin",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="admin@admin.com",
 *      ),
 *  *      @OA\Property(
 *          property="status",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 */
class AdminController extends Controller
{
    /**
     * @var  AdminService
     */
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        // Check permission
        // $this->middleware('permission:Admin.show', ['only' => ['show']]);
        // $this->middleware('permission:Admin.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:Admin.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:Admin.destroy', ['only' => ['destroy']]);

        $this->adminService = $adminService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/Admin",
     *      tags={"Admin"},
     *      operationId="indexAdmin",
     *      summary="List Admin",
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
     *                  @OA\Items(ref="#/components/schemas/Admin")
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
        $Admins = $this->adminService->listAdmin($params, ['roles']);

        $result = AdminResource::collection($Admins);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdminRequest $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Post(
     *      path="/api/Admin",
     *      tags={"Admin"},
     *      operationId="storeAdmin",
     *      summary="Create Admin",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Admin"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Admin",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(AdminRequest $request, Admin $Admin)
    {
        try {
            $params = $request->all();
            $params['password'] = bcrypt($params['password']);

            //checkDuplicateEmail
            $existEmail = $this->adminService->checkDuplicateData($request->email, 'email', $Admin);
            if ($existEmail) {
                return response()->failure(self::DUPLICATE_EMAIL, self::DUPLICATE_EMAIL_MESSAGE, self::CODE_ERROR_403);
            }

            // create Admin
            $Admin = $this->adminService->create($params);
            $result = new AdminResource($Admin);

            return response()->success(self::STORE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::STORE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $Admin
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/Admin/{id}",
     *      tags={"Admin"},
     *      operationId="showAdmin",
     *      summary="Get Admin",
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
     *                  property="Admin",
     *                  type="object",
     *                  ref="#/components/schemas/Admin",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show(Admin $Admin)
    {
        $result = new AdminResource($Admin);

        return response()->success(self::SHOW, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdminRequest $request
     * @param  \App\Models\Admin  $Admin
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/Admin/{id}",
     *      tags={"Admin"},
     *      operationId="updateAdmin",
     *      summary="Update Admin",
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
     *          @OA\JsonContent(ref="#/components/schemas/Admin"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Admin",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(UpdateAdminRequest $request, Admin $Admin)
    {
        try {
            $params = $request->all();
            // check duplicate email
            $existEmail = $this->adminService->checkDuplicateData($request->email, 'email', $Admin);
            if ($existEmail) {
                return response()->failure(self::DUPLICATE_EMAIL, self::DUPLICATE_EMAIL_MESSAGE, 403);
            }

            // check update Admin
            $Admin = $this->adminService->updateAdmin($params, $Admin);
            $result = new AdminResource($Admin);

            return response()->success(self::UPDATE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $Admin
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/Admin/{id}",
     *      tags={"Admin"},
     *      operationId="deleteAdmin",
     *      summary="Delete Admin",
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
    public function destroy(Admin $Admin)
    {
        $result = $this->adminService->destroy($Admin);

        return response()->success(self::REMOVE, $result);
    }
}
