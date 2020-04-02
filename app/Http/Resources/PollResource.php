<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
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
            'title' => $this->title,
            'thumbnail' => $this->thumbnail,
            'description' => $this->description,
            'rules' => $this->rules,
            'category'=> new CategoryResource($this->category),
            'createuser'=> $this->owner->name,
            'verifyuser'=> $this->when($this->auditor, function () {
                                return $this->auditor->name;
                            }),
            'vote_count' => $this->vote_count,
            'show_votecount' => $this->show_votecount,
            'verifyflag' => $this->verifyflag,
            'endflag' => $this->endflag,
            'votes' => VoteResource::collection($this->whenLoaded('votes')),
        ];
    }
}
