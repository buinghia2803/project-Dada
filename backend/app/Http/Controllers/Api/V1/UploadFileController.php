<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Upload\UploadService;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    /**
     * @var App\Services\UploadService uploadService
     */
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        // Check permission
        // $this->middleware('permission:permission.show', ['only' => ['show']]);
        // $this->middleware('permission:permission.store', ['only' => ['create', 'store']]);
        // $this->middleware('permission:permission.update', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:permission.destroy', ['only' => ['destroy']]);

        $this->uploadService = $uploadService;
    }

    /**
     * Upload local file.
     *
     * @param mixed $request.
     * @return mixed
     */
    public function uploadFile(Request $request)
    {
        $path = $this->uploadService->uploadFile($request->upload, 'mail-template');
        return response()->json(["url" => $request->root() . '/' . $path]);
    }
}
