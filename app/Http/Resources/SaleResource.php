<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'code' => $this->code,
            'customer' => new CustomerResource($this->customer),
            'seller' => new UserResource($this->seller),
            'total' => $this->total,
            'details' => SaleDetailResource::collection($this->details),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}
