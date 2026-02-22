<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'next_billing_date',
        'used_upload_gb',
        'used_download_gb',
        'clash_url',
        'shadowrocket_url',
    ];

    protected $casts = [
        'next_billing_date' => 'date',
        'used_upload_gb' => 'float',
        'used_download_gb' => 'float',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
