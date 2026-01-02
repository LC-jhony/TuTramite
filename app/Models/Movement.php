<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
        'document_id',
        // 'transaction_number',
        'origin_office_id',
        'origin_user_id',
        'destination_office_id',
        'destination_user_id',
        'action',
        'indication',
        'observation',
        // 'urgent_priority',
        // 'movement_date',
        'receipt_date',
        // 'service_date',
        'status',
        //   'requires_response',
        // 'is_copy',
    ];
}
