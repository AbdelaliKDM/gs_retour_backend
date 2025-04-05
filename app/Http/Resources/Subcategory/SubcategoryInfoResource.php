<?php

namespace App\Http\Resources\Subcategory;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryInfoResource extends JsonResource
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
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'name_fr' => $this->name_fr,
            'image' => $this->image_url,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at
        ];
    }
}
