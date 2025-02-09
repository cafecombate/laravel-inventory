<?php

namespace Controlla\Inventory\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Controlla\Inventory\Exceptions\InvalidPartException;

trait HasAssembly
{
    /*
     * Helpers for starting database transactions
     */
    use DatabaseTransactionTrait;

    /*
     * Verification helper functions
     */
    use VerifyTrait;

    /**
     * The belongsToMany assemblies relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assemblies()
    {
        return $this->belongsToMany($this, 'inventory_assemblies', 'inventory_id', 'part_id')->withPivot(['quantity'])->withTimestamps();
    }

    /**
     * Makes the current item an assembly.
     *
     * @return $this
     */
    public function makeAssembly()
    {
        $this->setAttribute('is_assembly', true);

        return $this->save();
    }

    /**
     * Adds an item to the current assembly.
     *
     * @param  int|float|string  $quantity
     * @return $this
     *
     * @throws \Controlla\Inventory\Exceptions\InvalidQuantityException
     */
    public function addAssemblyItem(Model $part, $quantity = 1, array $extra = [])
    {
        if ($this->isValidQuantity($quantity)) {
            if (! $this->getAttribute('is_assembly')) {
                $this->makeAssembly();
            }

            if ($part->getAttribute('is_assembly')) {
                $this->validatePart($part);
            }

            $attributes = array_merge(['quantity' => $quantity], $extra);

            if ($this->assemblies()->save($part, $attributes)) {
                $this->fireEvent('inventory.assembly.part-added', [
                    'item' => $this,
                    'part' => $part,
                ]);

                return $this;
            }
        }

        return false;
    }

    /**
     * Adds multiple parts to the current items assembly.
     *
     * @param  int|float|string  $quantity
     * @return int
     *
     * @throws \Controlla\Inventory\Exceptions\InvalidQuantityException
     */
    public function addAssemblyItems(Collection $parts, $quantity = 1, array $extra = [])
    {
        $count = 0;

        if (count($parts) > 0) {
            foreach ($parts as $part) {
                if ($this->addAssemblyItem($part, $quantity, $extra)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * Updates the inserted parts quantity for the current
     * item's assembly.
     *
     * @param  int|string|Model  $part
     * @param  int|float|string  $quantity
     * @return $this|bool
     *
     * @throws \Controlla\Inventory\Exceptions\InvalidQuantityException
     */
    public function updateAssemblyItem($part, $quantity = 1, array $extra = [])
    {
        if ($this->isValidQuantity($quantity)) {
            $id = $part;

            if ($part instanceof Model) {
                $id = $part->getKey();
            }

            $attributes = array_merge(['quantity' => $quantity], $extra);

            if ($this->assemblies()->updateExistingPivot($id, $attributes)) {
                $this->fireEvent('inventory.assembly.part-updated', [
                    'item' => $this,
                    'part' => $part,
                ]);

                return $this;
            }
        }

        return false;
    }

    /**
     * Updates multiple parts with the specified quantity.
     *
     * @param  int|float|string  $quantity
     * @return int
     *
     * @throws \Controlla\Inventory\Exceptions\InvalidQuantityException
     */
    public function updateAssemblyItems(Collection $parts, $quantity, array $extra = [])
    {
        $count = 0;

        if (count($parts) > 0) {
            foreach ($parts as $part) {
                if ($this->updateAssemblyItem($part, $quantity, $extra)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * Removes the specified part from
     * the current items assembly.
     *
     * @param  int|string|Model  $part
     * @return bool
     */
    public function removeAssemblyItem($part)
    {
        if ($this->assemblies()->detach($part)) {
            $this->fireEvent('inventory.assembly.part-removed', [
                'item' => $this,
                'part' => $part,
            ]);

            return true;
        }

        return false;
    }

    /**
     * Removes multiple parts from the current items assembly.
     *
     *
     * @return int
     */
    public function removeAssemblyItems(array $parts)
    {
        $count = 0;

        if (count($parts) > 0) {
            foreach ($parts as $part) {
                if ($this->removeAssemblyItem($part)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * Scopes the current query to only retrieve
     * inventory items that are an assembly.
     *
     *
     * @return mixed
     */
    public function scopeAssembly($query)
    {
        return $query->where('is_assembly', true);
    }

    /**
     * Validates that the inserted parts assembly
     * does not contain the current item. This
     * prevents infinite recursion.
     *
     *
     * @return bool
     *
     * @throws InvalidPartException
     */
    protected function validatePart(Model $part)
    {
        if ((int) $part->getKey() === (int) $this->getKey()) {
            $message = 'An item cannot be an assembly of itself.';

            throw new InvalidPartException($message);
        }

        return true;
    }
}
