<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'document_number',
        'file_number',
        'subject',
        'document_type_id',
        'priority_id',
        'administration_id',
        'sender_type',
        'sender_user_id',
        'destination_office_id',
        'destination_user_id',
        'content',
        'document_date',
        'response_deadline',
        'status',
        'reference_document_id',
        'registered_by_user_id',
    ];
}
