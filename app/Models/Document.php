<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    protected $fillable = [
        'customer_id',
        'document_number',
        'case_number',
        'subject',
        'origen',
        'document_type_id',
        'area_origen_id',
        'gestion_id',
        'user_id',
        'folio',
        'reception_date',
        'response_deadline',
        'condition',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function officeOrigen()
    {
        return $this->belongsTo(Office::class, 'area_origen_id');
    }

    public function gestion()
    {
        return $this->belongsTo(Administration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(
            related: DocumentFile::class,
            foreignKey: 'document_id',
        );
    }
}
