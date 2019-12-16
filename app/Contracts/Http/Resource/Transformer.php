<?php
namespace App\Contracts\Http\Resource;

use Illuminate\Http\Resources\Json\Resource;

class Transformer extends Resource
{
    public function all($request)
    {
        if ($this->resource === null) {
            return $this->resource;
        }

        if ($this->resource instanceof \Illuminate\Http\Resources\MissingValue) {
            return null;
        }
        $data = $this->toArray($request);
        foreach ($data as $key => $value) {
            if ($value instanceof Resource) {
                $data[$key] = $value->all($request);
            } elseif ($data instanceof Arrayable || $data instanceof Collection) {
                $data[$key] = $value->toArray();
            } elseif ($data instanceof JsonSerializable) {
                $data[$key] = $value->jsonSerialize();
            }
        }

        return $this->filter($data);
    }

    /**
     * Create new anonymous resource collection.
     *
     * @param  mixed  $resource
     * @return AnonymousCollectionTransformer
     */
    public static function collection($resource)
    {
        return new AnonymousCollectionTransformer($resource, get_called_class());
    }
}
