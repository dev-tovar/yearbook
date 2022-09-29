<?php

namespace App\Models;

use App\School;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $guarded =['id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
