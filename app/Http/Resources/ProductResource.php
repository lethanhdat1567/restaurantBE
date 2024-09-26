<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->title,
            'price' => $this->price,
            'discount' => $this->discount,
            'img' => $this->thumbnail,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'content' => $this->content,
            'total' => intval($this->total),
            'deleted' => $this->deleted,
            'categoryTB' => new CategoryResource($this->whenLoaded('category')),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
           ];
    }
}
