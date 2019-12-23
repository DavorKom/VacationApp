<?php

namespace App\Http\Resources;

use App\Contracts\Http\Resource\Transformer;
use App\Http\Resources\RoleResource;
use App\Http\Resources\DateTimeResource;
use App\Http\Resources\BasicTeamResource;

class UserResource extends Transformer
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
            'role' => (new RoleResource($this->role))->all($request),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'contract_date' => (new DateTimeResource($this->contract_date))->all($request),
            'team' => (new BasicTeamResource($this->whenLoaded('team')))->all($request),
            'vacation_data' => (new BasicVacationData($this->whenLoaded('vacationData')))->all($request)
        ];
    }
}
