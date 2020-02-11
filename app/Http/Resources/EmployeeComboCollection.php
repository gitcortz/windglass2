<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeComboCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => EmployeeComboResource::collection($this->collection),
        ];
    }
}
