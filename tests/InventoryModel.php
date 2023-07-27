<?php

namespace Controlla\Inventory\Tests;

use Illuminate\Database\Eloquent\Model;
use Controlla\Inventory\Traits\HasInventory;

class InventoryModel extends Model
{
    use HasInventory;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = [];
}
