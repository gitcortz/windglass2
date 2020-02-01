<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerComboResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->id,
            'label' => $this->name,
            'address' => $this->address,
            'city' => $this->city['name'],
            'phone' => $this->phone,
            'mobile' => $this->mobile,
          ];
    }
}
