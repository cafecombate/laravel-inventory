<?php

namespace Controlla\Inventory\Traits;

use Controlla\Inventory\Models\Warehouse;

trait HasWarehouses
{
    /**
     * The hasMany warehouses relationship.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function warehouses()
    {
        return $this->morphMany(Warehouse::class, 'warehouseable')->latest('id');
    }
}
