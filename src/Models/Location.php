<?php

namespace Controlla\Inventory\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Controlla\Inventory\Models\InventoryStock
 *
 * @property int $warehouse_id
 */
class Location extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'name',
    ];

    /**
     * The belongsTo warehouse relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    /**
     * The hasMany stocks relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(InventoryStock::class);
    }
}
