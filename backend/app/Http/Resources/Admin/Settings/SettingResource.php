<?php

namespace App\Http\Resources\Admin\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'created_at' => $this->created_at,
                'id' => $this->id,
                'opensea_percent' => $this->opensea_percent,
                'system_percent' => $this->system_percent,
                'updated_at' => $this->updated_at,
            ];
    }
}
