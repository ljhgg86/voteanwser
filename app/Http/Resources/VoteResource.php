<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class VoteResource extends JsonResource
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
            'start_at'=> $this->start_at,
            'end_at'=> $this->end_at,
            'view_end_at'=> $this->view_end_at,
            'option_count'=> $this->option_count,
            'option_type'=> $this->option_type,
            'vote_type'=> $this->vote_type,
            'vote_count'=> $this->vote_count,
            'show_votecount'=> $this->show_votecount,
            'description'=> $this->description,
            'voteflag'=>$this->canVote,
            'voteInfos'=> VoteInfoResource::collection($this->whenLoaded('voteInfos')),
            'options'=>OptionResource::collection($this->whenLoaded('options')),
        ];

    }
}
