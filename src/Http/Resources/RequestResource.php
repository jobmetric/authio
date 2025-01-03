<?php

namespace JobMetric\Authio\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'source' => $this['source'],
            'type' => $this['type'],
            'has_password' => $this['has_password'],
            'secret' => $this['secret'],
            'code' => $this['code'],
        ];
    }
}
