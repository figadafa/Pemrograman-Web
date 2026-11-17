<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'title' => $this->title,
            'category' => $this->category,
            'creator' => $this->creator,
            'year' => $this->year,
            'studio' => $this->studio,
            'country' => $this->country,
            'genre' => $this->genre,
            'total_volumes' => $this->total_volumes,
            'duration_minutes' => $this->duration_minutes,
            'total_chapters' => $this->total_chapters,
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
