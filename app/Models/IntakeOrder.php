<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntakeOrder extends Model
{
    protected $fillable = [
        'reference_no',
        'supplier',
        'received_at',
        'user_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'received_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(IntakeOrderItem::class);
    }

    public static function generateReferenceNo(): string
    {
        $prefix = 'IN-' . now()->format('Ymd');
        $last = static::where('reference_no', 'like', $prefix . '%')
            ->orderByDesc('reference_no')
            ->value('reference_no');

        $seq = $last ? (int) substr($last, -4) + 1 : 1;

        return $prefix . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
