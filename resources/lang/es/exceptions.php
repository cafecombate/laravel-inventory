<?php

/**
 * The Inventory Exceptions language file.
 *
 * @author Steve Bauman
 */
return [

    'InvalidLocationException' => 'Localización :location es invalida',

    'InvalidMovementException' => 'Movimiento :movement es invalido',

    'InvalidSupplierException' => 'Proveedor :supplier es invalido',

    'InvalidItemException' => 'Item :item es invalido',

    'InvalidQuantityException' => 'Cantidad :quantity es invalida',

    'NotEnoughStockException' => 'Stock insuficiente. Se requiere :quantity pero solo existe :available',

    'NoUserLoggedInException' => 'No se puede recuperar la ID de usuario',

    'StockAlreadyExistsException' => 'Stock already exists on location :location',

    'StockNotFoundException' => 'No stock was found from location :location',

    'SkuAlreadyExistsException' => 'An SKU already exists for this item',

];
