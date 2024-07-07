<?php

namespace App\Http\Resources;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UseFeatureResource extends JsonResource
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
            'credits' => $this->credits,
            'feature' => new FeatureResourcse($this->feature),
            'created_at' => $this->created_by->format('Y-m-d H:i:s'),
            'data' => $this->data,
        ];
    }
}
