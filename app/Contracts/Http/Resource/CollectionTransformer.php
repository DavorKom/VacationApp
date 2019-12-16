<?php
namespace App\Contracts\Http\Resource;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectionTransformer extends ResourceCollection
{
    public function all($request)
    {
        return $this->collection ? $this->collection->map->all($request) : [];
    }
}
