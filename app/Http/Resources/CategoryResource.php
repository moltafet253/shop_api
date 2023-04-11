<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'id'=>$this->id,
            'parent_id'=>$this->parent_id,
            'name'=>$this->name,
            'description'=>$this->description,
            'children'=>CategoryResource::collection($this->whenLoaded('children')),
            'parent'=>CategoryResource($this->whenLoaded('parent')),
            'products'=>ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}
