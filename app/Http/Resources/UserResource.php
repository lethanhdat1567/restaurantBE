<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        'fullname' => $this->fullname,
        'avatar' => $this->avatar,
        'phone_number' => $this->phone_number,
        'email' => $this->email,
        'address' => $this->address,
        'role_id' => $this->role_id,
        'deleted' => $this->deleted,
        'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
        'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
       ];
    }
}
