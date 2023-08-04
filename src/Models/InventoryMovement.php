<?php

namespace IvanSotelo\Inventory\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    /**
     * The inventory movements table.
     *
     * @var string
     */
    protected $table = 'inventory_movements';

    protected $fillable = [
        'stock_id',
        'warehouse_id',
        'character',
        'user_id',
        'before',
        'after',
        'cost',
        'reason',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    /**
     * The belongsTo stock relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(InventoryStock::class)->with('location', 'inventoriable');
    }

    /**
     * The belongsTo warehouse relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
