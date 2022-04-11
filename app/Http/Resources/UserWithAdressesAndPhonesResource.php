<?php

namespace App\Http\Resources;

use Database\Seeders\AddressTableSeeder;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWithAdressesAndPhonesResource extends JsonResource
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
            'surname'=>$this->surname,
            'email'=>$this->email,
            'addresses'=>AddressesResource::collection($this->whenLoaded('addresses')),
            'phones'=>PhonesResource::collection($this->whenLoaded('phones'))

        ];
    }
}
