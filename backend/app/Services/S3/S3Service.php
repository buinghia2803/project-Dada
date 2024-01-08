<?php

namespace App\Services\S3;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Helpers\DateHelper;

class S3Service
{

    /**
     * FileManageService construct
     */

    public function __construct()
    {
    }

    /**
     * Storage getFileFolder
     *
     * @param Array $data
     */
    public function getFileFolder($data)
    {
        try {
            $result = null;
            $folder = isset($data['folder']) ? $data['folder'] : '';
            $result = Storage::disk('s3')->allDirectories($folder);

            return $result;
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Get original file name
     *
     * @param mixed $file
     */
    public function getFileName($file)
    {
        return $file->getClientOriginalName();
    }

    /**
     * Get client to prefix
     *
     * @param mixed $isAdminFrefix
     */
    public function getPrefix($isAdminFrefix)
    {
        return $isAdminFrefix ? config('constant.prefix.system_admin') : config('constant.prefix.system_user');
    }

    /**
     * Storage createFolder
     *
     * @param Array $data
     */
    public function createFolder($data)
    {
        try {
            $result = null;
            $folder = isset($data['folder']) ? $data['folder'] : '';
            $result = Storage::disk('s3')->makeDirectory($folder);

            return $result;
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Storage renameFolder
     *
     * @param Array $data
     */
    public function renameFolder($data)
    {
        try {
            $folder = isset($data['folder']) ? $data['folder'] : '';
            $newfolder = isset($data['newFolder']) ? $data['newFolder'] : '';
            $result = false;

            if (Storage::disk('s3')->has($folder)) {
                $folderContents = Storage::disk('s3')->listContents($folder, true);
                if (count($folderContents) > 0) {
                    foreach ($folderContents as $content) {
                        if ($content['type'] === 'file') {
                            $src  = $content['path'];
                            $dest = str_replace($folder, $newfolder, $content['path']);
                            $result = Storage::disk('s3')->move($src, $dest);
                        }
                    }
                } else {
                    $result = Storage::disk('s3')->makeDirectory($newfolder);
                }

                $result = Storage::disk('s3')->deleteDirectory($folder);
            }
            if ($result) {
                $this->moveFileFolder($folder, $newfolder);
            }
            return $result;
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    /**
     * Storage moveFileFolder
     *
     * @param Array $data
     */
    public function moveFileFolder($folder, $newfolder)
    {
        try {
            $files = $this->fileManageRepository->list([])->where('folder', $folder)->toArray();
            if (count($files) > 0) {
                foreach ($files as $item) {
                    DB::table('file_manages')->where('id', $item['id'])->update(['folder' => $newfolder]);
                }
            }
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    /**
     * Storage deleteFolder
     *
     * @param Array $data
     */
    public function deleteFolder($data)
    {
        try {
            $folder = isset($data['folder']) ? $data['folder'] : '';
            $result = Storage::disk('s3')->deleteDirectory($folder);

            if ($result) {
                $this->deleteFileFolder($folder);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    /**
     * Storage deleteFileFolder
     *
     * @param Array $data
     */
    public function deleteFileFolder($folder)
    {
        try {
            $ids = [];
            $files = $this->fileManageRepository->list([])->where('folder', $folder)->toArray();
            if (count($files) > 0) {
                foreach ($files as $item) {
                    $ids[] = $item['id'];
                }
            }
            DB::table('file_manages')->whereIn('id', $ids)->delete();
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    /**
     * Storage upload specific disk
     */
    public function upload($file, $path)
    {
        try {
            $fileName = $this->getFileName($file);
            $result = $file->storeAs($path, $fileName);
            // $result = Storage::disk('public')->put($path, file_get_contents($file));

            return $result;
        } catch (\Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    /**
     * Storage getAllFile
     *
     * @param String $data
     */
    public function getAllFile($data)
    {
        try {
            $folder = isset($data['folder']) ? $data['folder'] : '';
            $result = Storage::disk('s3')->allFiles($folder);

            return $result;
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Storage deleteFolder
     *
     * @param Object $data
     */
    public function uploadFile($request)
    {
        try {
            $result = null;
            $folder = isset($request['folder']) ? $request['folder'] : '';
            if ($request->hasFile('fileName')) {
                $file = $request->file('fileName');
                $name = time() . $file->getClientOriginalName();
                $folder = $folder . $name;
                $result = Storage::disk('s3')->put($folder, file_get_contents($file));
            }

            return $result;
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Storage deleteFolder
     *
     * @param Object $data
     */
    public function uploadFileS3($path, $file)
    {
        try {
            if ($file) {
                if(config('AWS_ACCESS_KEY_ID')) {
                    $result = Storage::disk('s3')->put($path, $file);
                } else {
                    $result = Storage::disk('public')->put($path, $file);
                }
            }

            return $result;
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    /**
     * Set path S3
     *
     * @param mixed $file
     * @param mixed $resource
     * @param mixed $isAdminFrefix
     */
    public function setPathS3($resource, $isAdminFrefix = true)
    {
        $prefix = $this->getPrefix($isAdminFrefix);

        $now = DateHelper::getNow(null);

        $currentMonth = $now->format('Ym');
        $currentTime = $now->format('YmdHis');

        $arrPath = array($prefix, $resource, $currentMonth, $currentTime);

        $pathS3 = implode("/", $arrPath);

        return $pathS3;
    }

    /**
     * Destroy file from s3 resource
     *
     * @param String url
     */
    public function destroy($url)
    {
        $s3Domain = config('constant.s3_domain');
        $s3Disk = config('constant.s3_disk');

        $path = str_replace($s3Domain, "", $url);
        $result = Storage::disk($s3Disk)->delete($path);

        return $result;
    }
}
