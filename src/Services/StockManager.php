<?php
namespace Branzia\Shop\Services;

use Branzia\Shop\Models\Inventory;
use Branzia\Shop\Models\InventoryMovement;

class StockManager
{
    public static function add(Inventory $inventory, int $qty, ?string $reason = null): void
    {
        $inventory->qty += $qty;
        $inventory->stock_status = $inventory->qty > 0 ? 'in_stock' : 'out_of_stock';
        $inventory->save();

        InventoryMovement::create([
            'product_id'    => $inventory->product_id,
            'warehouse_id'  => $inventory->warehouse_id,
            'movement_type' => 'add',
            'quantity'      => $qty,
            'reason'        => $reason,
        ]);
    }

    public static function remove(Inventory $inventory, int $qty, ?string $reason = null): void
    {
        $inventory->qty = max(0, $inventory->qty - $qty);
        $inventory->stock_status = $inventory->qty > 0 ? 'in_stock' : 'out_of_stock';
        $inventory->save();

        InventoryMovement::create([
            'product_id'    => $inventory->product_id,
            'warehouse_id'  => $inventory->warehouse_id,
            'movement_type' => 'remove',
            'quantity'      => $qty,
            'reason'        => $reason,
        ]);
    }

    public static function reserve(Inventory $inventory, int $qty): bool
    {
        if ($inventory->availableQty() >= $qty) {
            $inventory->qty_reserved += $qty;
            $inventory->save();

            InventoryMovement::create([
                'product_id'    => $inventory->product_id,
                'warehouse_id'  => $inventory->warehouse_id,
                'movement_type' => 'reserve',
                'quantity'      => $qty,
                'reason'        => 'Stock reserved',
            ]);
            return true;
        }
        return false;
    }

    public static function release(Inventory $inventory, int $qty): void
    {
        $inventory->qty_reserved = max(0, $inventory->qty_reserved - $qty);
        $inventory->save();

        InventoryMovement::create([
            'product_id'    => $inventory->product_id,
            'warehouse_id'  => $inventory->warehouse_id,
            'movement_type' => 'release',
            'quantity'      => $qty,
            'reason'        => 'Stock released',
        ]);
    }
}
