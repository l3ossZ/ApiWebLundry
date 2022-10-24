<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'role'=>$this->role,
            'salary'=>$this->salary,
            'address'=>$this->address,
            'ID_Card'=>$this->ID_Card,
            'bank_account_number'=>$this->bank_account_number,
            'bank_name'=>$this->bank_name,
        ];
    }
}
