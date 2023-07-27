<?php

namespace Controlla\Inventory;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Controlla\Inventory\Inventory
 */
class InventoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'inventory';
    }
}
