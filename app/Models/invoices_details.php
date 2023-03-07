<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    protected $fillable = [
        'id_invoices',
        'invoice_number',
        'section',
        'product',
        'status',
        'value_status',
        'note',
        'user',
        'payment_date',
    ];
}
