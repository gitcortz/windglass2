<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeComboResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->id,
            'label' => $this->name,
            'employeetype' => $this->employee_type['name'],
            'base_salary' => $this->base_salary,
          ];
    }
}
