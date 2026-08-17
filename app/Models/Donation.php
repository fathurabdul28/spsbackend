<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'program_id',
        'user_id',
        'bank_account_id',
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'payment_type',
        'status',
        'snap_token',
        'proof_of_payment',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
