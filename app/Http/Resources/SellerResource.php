<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'avatar' => $this->profile_photo
                ? Storage::url($this->profile_photo)
                : asset('images/default-avatar.png'),
        ];
    }

}
