<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
     protected $fillable = [
        'auditable_id',
        'auditable_type',
        'user_id',
        'action',
        'old_values',
        'new_values'
    ];

    public function auditable()
    {
        return $this->morphTo();
    }
}
