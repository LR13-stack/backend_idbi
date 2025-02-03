<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->name,
            'document_id' => $this->document_id,
            'number_id' => $this->number_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
        ];
    }
}
