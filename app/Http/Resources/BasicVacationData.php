<?php

namespace App\Http\Resources;

use App\Contracts\Http\Resource\Transformer;

class BasicVacationData extends Transformer
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
            'unused_vacation' => $this->unused_vacation,
            'used_vacation' => $this->used_vacation,
            'paid_leave' => $this->paid_leave
        ];
    }
}
