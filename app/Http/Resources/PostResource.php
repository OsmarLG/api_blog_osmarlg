<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'address' => json_decode($this->user->address),
                'phone' => $this->user->phone,
                'website' => $this->user->website,
                'website' => $this->user->website,
                'company' => json_decode($this->user->company),
            ],
            'status' => $this->status ?? 'Inactive',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
