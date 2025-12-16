<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'note',
        'loan_date',
        'return_date',
        'returned_date',
        'penalty_price',
        'penalty_per_day'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function loan_items()
    {
        return $this->hasMany('App\Models\LoanItem');
    }
}
