<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Booking extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
       return [
        'id' => $this->id,
        'name' => $this->fullname,
        'phone_number' => $this->phone_number,
        'email' => $this->email,
        'quantity' => $this->quantity,
        'address' => $this->address,
        'deleted' => $this->deleted,
        'time' => $this->time,
        'date' =>(new \DateTime($this->date))->format('Y-m-d'),
       ];
    }
}
