<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoces_report extends Model
{
    use HasFactory;

    public function section()
    {
        return $this -> belongsTo(sections::class);
    }
}
