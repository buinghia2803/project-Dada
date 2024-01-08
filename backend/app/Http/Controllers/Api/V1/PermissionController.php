<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Resources\Permission\PermissionResource;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * @var App\Services\permissionService permissionService
     */
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        // Check permission
        // $this->middleware('permission:permission.show', ['only' => ['show']]);
        // $this->middleware('permission:permission.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:permission.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:permission.destroy', ['only' => ['destroy']]);

        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $permission = $this->permissionService->list($input);
        $result = PermissionResource::collection($permission);

        return response()->success(self::INDEX, $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Permission\CreatePermissionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePermissionRequest $request)
    {
        $input = $request->all();

        // check duplicate name permission
        $exitsName = $this->permissionService->checkDuplicateData($request->name, 'name');
        if ($exitsName) {
            return response()->failure(self::DUPLICATE_NAME, self::DUPLICATE_NAME_MESSAGE, 403);
        }

        $permission = $this->permissionService->create($input);
        $result = new PermissionResource($permission);

        return response()->success(self::STORE, $result);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Permission $permission)
    {
        $input = $request->all();
        $result = new PermissionResource($permission);

        return response()->success(self::SHOW, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Permission\UpdatePermissionRequest $request
     * @param \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $input = $request->all();

        // check duplicate name permission
        $exitsName = $this->permissionService->checkDuplicateData($request->name, 'name', $permission);
        if ($exitsName) {
            return response()->failure(self::DUPLICATE_NAME, self::DUPLICATE_NAME_MESSAGE, 403);
        }

        $this->permissionService->update($permission, $input);
        $result = new PermissionResource($permission);

        return response()->success(self::UPDATE, $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $result = $this->permissionService->destroy($permission);

        return response()->success(self::REMOVE, $result);
    }
}
