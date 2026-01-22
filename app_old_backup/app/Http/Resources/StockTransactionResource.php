<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockTransactionResource extends JsonResource
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
            'item_id' => $this->item_id,
            'item' => [
                'id' => $this->item->id,
                'name' => $this->item->name,
                'sku' => $this->item->sku,
            ],
            'transaction_type' => $this->transaction_type,
            'quantity' => $this->quantity,
            'location_id' => $this->location_id,
            'location' => $this->location ? [
                'id' => $this->location->id,
                'name' => $this->location->name,
                'warehouse_id' => $this->location->warehouse_id,
            ] : null,
            'user_id' => $this->user_id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'notes' => $this->notes,
            'transaction_date' => $this->transaction_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}