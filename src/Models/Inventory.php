<?php

namespace Branzia\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Branzia\Catalog\Models\Product;
class Inventory extends Model
{
    protected $fillable = [
        'product_id', 'qty', 'qty_reserved', 'warehouse_id','manage_stock', 'stock_status'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function isInStock()
    {
        return $this->stock_status === 'in_stock' && $this->qty > 0;
    }
    public function availableQty(): int
    {
        return max(0, $this->qty - $this->qty_reserved);
    }
}
