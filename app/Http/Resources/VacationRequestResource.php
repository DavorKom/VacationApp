<?php

namespace App\Http\Resources;

use App\Contracts\Http\Resource\Transformer;
use App\Http\Resources\DateTimeResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\TeamResource;

class VacationRequestResource extends Transformer
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
            'user' => (new UserResource($this->user))->all($request),
            'team' => (new TeamResource($this->whenLoaded('team')))->all($request),
            'from' => (new DateTimeResource($this->from))->all($request),
            'to' => (new DateTimeResource($this->to))->all($request),
            'used_vacation' => $this->used_vacation,
            'note' => data_get($this, 'note'),
            'project_manager_note' => data_get($this, 'project_manager_note'),
            'project_manager_status' => $this->project_manager_status,
            'team_lead_note' => data_get($this, 'team_lead_note'),
            'team_lead_status' => $this->team_lead_status,
            'status' => $this->status
        ];
    }
}
