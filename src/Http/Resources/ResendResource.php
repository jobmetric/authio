<?php

namespace JobMetric\Authio\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResendResource extends JsonResource
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
            'secret' => $this['secret'],
            'code' => $this['code'] ?? null,
        ];
    }
}
