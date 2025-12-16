<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'book_id',
        'book_title',
        'loan_id',
        'quantity'
    ];
    protected $table = 'loans_items';


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }

    public function loan()
    {
        return $this->belongsTo('App\Models\Loan');
    }
}
