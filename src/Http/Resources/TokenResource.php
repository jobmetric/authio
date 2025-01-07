<?php

namespace JobMetric\Authio\Http\Resources;

use Carbon\Carbon;
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
                'expires_in' => Carbon::now()->addMinutes(config('jwt.ttl'))->timestamp,
            ],
            'user' => UserResource::make($this['user']),
        ];
    }
}
