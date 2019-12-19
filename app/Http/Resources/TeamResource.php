<?php

namespace App\Http\Resources;

use App\Contracts\Http\Resource\Transformer;
use App\Http\Resources\UserResource;

class TeamResource extends Transformer
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
            'name' => $this->name,
            'project_manager' => (new UserResource($this->whenLoaded('projectManager')))->all($request),
            'team_lead' => (new UserResource($this->whenLoaded('teamLead')))->all($request),
            'users' => $this->users($request)
        ];
    }

    public function users($request)
    {
        if($this->users) {
            return UserResource::collection($this->whenLoaded('users'))->toArray($request);
        }

        return null;
    }
}