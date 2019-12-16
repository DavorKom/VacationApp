<?php

namespace App\Http\Resources;

use App\Contracts\Http\Resource\Transformer;
use Illuminate\Support\Carbon;

class DateTimeResource extends Transformer
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
            'standard' => Carbon::parse($this->resource)->format('d.m.Y.'),
            'datepicker' => Carbon::parse($this->resource)->format('Y-m-d')
        ];
    }
}
