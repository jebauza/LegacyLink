<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationApiResource extends JsonResource
{
    public function toArray($request)
    {
        $resource = $this->resource->toArray();

        return [
            'current_page' => $this->currentPage(),
            'from' => $resource['from'],
            'to' => $resource['to'],
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'count' => $this->count(),
            'total' => $this->total(),
            'items' => $this->getCollection(),
        ];
    }
}
