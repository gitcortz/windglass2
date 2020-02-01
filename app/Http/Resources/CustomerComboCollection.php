<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerComboCollection extends ResourceCollection
{
    public function toArray($request)
    {
        //return parent::toArray($request);
        /*return [
            'data' => $this->collection,
        ];*/
        return [
            'data' => CustomerComboResource::collection($this->collection),
        ];
    }
}
