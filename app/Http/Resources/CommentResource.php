<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
        'user_id' => $this->user_id,
        'product_id' => $this->product_id,
        'parent_id' => $this->parent_id,
        'star' => $this->star,
        'comment' => $this->comment,
        'created_at' => (new \DateTime($this->created_at))->format('Y-m-d'),
        'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d'),
       ];
    }
}
