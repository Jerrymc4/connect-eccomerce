<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Domain as BaseDomain;

class Domain extends BaseDomain
{
    protected $fillable = ['domain'];

    public function tenant()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
} 