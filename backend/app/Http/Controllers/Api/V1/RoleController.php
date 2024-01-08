<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Response;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\RolePermission\RoleResource;
use App\Http\Resources\RolePermission\PermissionResource;

/**
 *  @OA\Tag(
 *      name="Role",
 *      description="Role Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="role",
 *      @OA\Property(
 *          property="name",
 *          type="number",
 *          example=1,
 *      ),
 *      @OA\Property(
 *          property="guard_name",
 *          type="number",
 *          example=1,
 *      ),
 *  )
 */
class RoleController extends Controller
{
    /**
     * @var  App\Services\RoleService roleService
     */
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        // Check permission
        // $this->middleware('permission:role.show', ['only' => ['show']]);
        // $this->middleware('permission:role.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:role.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:role.destroy', ['only' => ['destroy']]);

        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/role",
     *      tags={"Role"},
     *      operationId="indexRole",
     *      summary="List Role",
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
     *                  @OA\Items(ref="#/components/schemas/role")
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
        $roles = $this->roleService->listRole($request->all());
        $list = RoleResource::collection($roles);

        return response()->success(self::INDEX, $list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest $request
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Post(
     *      path="/api/role",
     *      tags={"Role"},
     *      operationId="storeRole",
     *      summary="Create Role",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/role"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/role",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(RoleRequest $request, Role $role)
    {
        try {
            $data = $request->only('name');
            $role = $this->roleService->create($data);

            if ($request->permissions) {
                $this->roleService->syncPermissions($role, $request->permissions);
            }

            $result = new RoleResource($role);

            return response()->success(self::STORE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::STORE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/role/{id}",
     *      tags={"Role"},
     *      operationId="showRole",
     *      summary="Get Role",
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
     *                  ref="#/components/schemas/role",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show(Role $role)
    {
        $role = $this->roleService->detail($role, ['permissions']);

        $result = new RoleResource($role);

        return response()->success(self::STORE, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RoleRequest $request
     * @param  \App\Models\Role  $role
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/role/{id}",
     *      tags={"Role"},
     *      operationId="updateRole",
     *      summary="Update Role",
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
     *          @OA\JsonContent(ref="#/components/schemas/role"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/role",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(Request $request, Role $role)
    {
        try {
            $data = $request->only('name');
            $this->roleService->update($role, $data);

            if ($request->permissions) {
                $this->roleService->syncPermissions($role, $request->permissions);
            }

            $result = new RoleResource($role);

            return response()->success(self::UPDATE, $result);
        } catch (\Exception $e) {
            return response()->failure(self::UPDATE, $e->getMessage(), self::CODE_ERROR_400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return  \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/role/{id}",
     *      tags={"Role"},
     *      operationId="deleteRole",
     *      summary="Delete Role",
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
    public function destroy(Request $request)
    {
        $input = $request->all();
        $this->roleService->delete($input);

        return response()->success(self::DELETE);
    }

    /**
     * Get permission list.
     *
     * @return Response
     *
     *  @OA\Get(
     *      path="/api/permission",
     *      tags={"Role"},
     *      operationId="permission",
     *      summary="List Permission",
     *      @OA\Response(
     *          response=200,
     *          description="Listed",
     *      ),
     *  )
     */
    public function getPermissions()
    {
        $permissions = $this->roleService->getPermissions();

        $result = PermissionResource::collection($permissions);

        return response()->success(self::INDEX, $result);
    }
}
