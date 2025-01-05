<?php

namespace JobMetric\Authio\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'token',
            'token' => [
                'access_token' => $this['token'],
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ],
            'user' => UserResource::make($this['user']),
        ];
    }
}
