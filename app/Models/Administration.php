<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_period',
        'end_period',
        'mayor',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($administration) {
            if ($administration->status) {
                // Disable all other active administrations when creating a new active one
                self::where('status', true)->update(['status' => false]);
            }
        });

        static::updating(function ($administration) {
            if ($administration->isDirty('status') && $administration->status) {
                // Disable all other active administrations when updating an administration to active
                self::where('id', '!=', $administration->id)
                    ->where('status', true)
                    ->update(['status' => false]);
            }
        });
    }
}
