<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = ['material_id', 'quantity'];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Increment stock quantity and save.
     */
    public function addStock(int $qty): void
    {
        $this->increment('quantity', $qty);
    }

    /**
     * Decrement stock quantity and save. Throws exception if insufficient.
     */
    public function deductStock(int $qty): void
    {
        if ($this->quantity < $qty) {
            throw new \RuntimeException(__('wms.outgoing.error_stock'));
        }

        $this->decrement('quantity', $qty);
    }
}
