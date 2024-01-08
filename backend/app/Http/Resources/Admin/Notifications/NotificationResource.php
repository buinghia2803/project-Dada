<?php

namespace App\Http\Resources\Admin\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
                'id' => $this->id,
                'title' => $this->title,
                'content' => $this->content,
                'action' => $this->action,
                'type' => $this->type,
                'date_public' => $this->date_public,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}
