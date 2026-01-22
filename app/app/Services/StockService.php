<?php

namespace App\Services;

use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Exception;

class StockService
{
    public function createTransaction($data)
    {
        return DB::transaction(function () use ($data) {
            // Check for sufficient stock if it's an outgoing transaction
            if ($data['type'] === 'out') {
                $currentStock = $this->getCurrentStock($data['item_id'], $data['warehouse_id'], $data['location_id'] ?? null);
                if ($currentStock < $data['quantity']) {
                    throw new Exception("Insufficient stock. Current stock: {$currentStock}");
                }
            }

            return StockTransaction::create($data);
        });
    }

    public function getCurrentStock($itemId, $warehouseId, $locationId = null)
    {
        $query = StockTransaction::where('item_id', $itemId)
            ->where('warehouse_id', $warehouseId);

        if ($locationId) {
            $query->where('location_id', $locationId);
        }

        $incoming = (clone $query)->whereIn('type', ['in', 'adjustment'])->sum('quantity');
        $outgoing = (clone $query)->whereIn('type', ['out', 'transfer'])->sum('quantity');

        // Note: Logic simplification. Real logic should handle adjustments +/- correctly.
        // Assuming adjustment adds positive stock for now. If adjustment is absolute, logic changes.
        // For simplicity, let's assume 'adjustment' adds quantity (positive or negative stored in DB?)
        // Let's assume quantity is always positive, and type determines sign.

        // Re-evaluating: 'adjustment' might be a set value, or a delta. 
        // Let's assume standard simple inventory:
        // In -> +
        // Out -> -
        // Transfer -> - from source (handled as Out), + to dest (handled as In transaction separately?)
        // Or Transfer is one transaction? The schema has 1 warehouse/location. So transfer requires 2 transactions.

        // Let's refine based on the schema:
        // 'in': +
        // 'adjustment': + (if positive), - (if negative quantity allowed? Schema has quantity as int, typically positive).
        // Let's assume 'adjustment' can be In or Out effectively, but let's stick to simple In/Out for now.

        // Correct logic:
        $added = (clone $query)->where('type', 'in')->sum('quantity');
        $removed = (clone $query)->where('type', 'out')->sum('quantity');

        // Adjustments: if we treat adjustment as resetting stock, it's complex. 
        // If we treat adjustment just like 'in' (if positive) or 'out', we need a sign.
        // For now, let's assume 'adjustment' adds to stock (e.g. found items).
        $adjusted = (clone $query)->where('type', 'adjustment')->sum('quantity');

        return $added + $adjusted - $removed;
    }
}
