<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'option' => $this->option,
            'correctflag' => $this->isAnswer(),
            'thumbnail' => $this->thumbnail,
            'vote_count' => $this->vote_count,
            'description' => $this->description,
        ];
    }
}
