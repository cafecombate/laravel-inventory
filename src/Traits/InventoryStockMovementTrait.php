<?php

namespace Controlla\Inventory\Traits;

use Illuminate\Database\Eloquent\Model;

trait InventoryStockMovementTrait
{
    /**
     * Overrides the models boot function to set
     * the user ID automatically to every new record.
     *
     * @return void
     */
    public static function bootInventoryStockMovementTrait()
    {
        static::creating(function (Model $record) {
            $record->setAttribute('user_id', $record->getCurrentUserId());
        });
    }

    /**
     * The belongsTo stock relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    abstract public function stock();

    /**
     * Rolls back the current movement.
     *
     * @param  bool  $recursive
     * @return mixed
     */
    public function rollback($recursive = false)
    {
        return $this->stock->rollback($this, $recursive);
    }

    /**
     * Rolls back the current movement.
     *
     * @param  bool  $recursive
     * @return mixed
     */
    public function returnStock($collect_amt, $collect_reason, $collect_serial, $dispose_amt, $dispose_reason, $dispose_serial)
    {
        return $this->stock->returnStock($this, $collect_amt, $collect_reason, $collect_serial, $dispose_amt, $dispose_reason, $dispose_serial);
    }
}
