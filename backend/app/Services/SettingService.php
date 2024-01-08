<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Log;

class SettingService extends BaseService
{
    /**
     * Initializing the instances and variables
     *
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->repository = $settingRepository;
    }
    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function listSetting($params)
    {
        $setting = $this->findByCondition($params)->first();
        
        return $setting;
    }

    /**
     * @param Setting $setting
     *
     * @return void
     */
    public function delete($setting)
    {
        return $this->repository->delete($setting);
    }

    /**
     * UpdateOrCreateSetting
     *
     * @param  mixed $request
     * @return void
     */
    public function updateOrCreateSetting($request)
    {
        $conditions = [
            'id' => 1,
        ];
        $data = [
            'system_percent' => $request->system_percent,
            'opensea_percent' => $request->opensea_percent,
            'updated_at' => now()
        ];

        return $this->repository->updateOrCreate($conditions, $data);
    }
}
