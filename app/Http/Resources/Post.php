<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       // or you can write it in another way
       return [
           'id'=>$this->id,
           'user_id'=>$this->user_id,
           'title'=>$this->title,
           'description'=>$this->descriptio,
           'created_at'=>$this->created_at->format('d/m/y'),
           'updated_at'=>$this->updated_at->format('d/m/y')

       ];

    }
}
